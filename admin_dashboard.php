<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
require_once 'db.php';

$totalUsers   = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalFarmers = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'farmer'")->fetchColumn();
$totalBuyers  = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'buyer'")->fetchColumn();
$totalProduce = $conn->query("SELECT COUNT(*) FROM produce")->fetchColumn();
$totalOrders  = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalRevenue = $conn->query("SELECT SUM(o.quantity * p.price_per_kg)
    FROM orders o JOIN produce p ON o.produce_id = p.id WHERE o.status = 'delivered'")->fetchColumn();

$orderStatus = $conn->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status")->fetchAll();
$topFarmers = $conn->query("
    SELECT u.name, SUM(o.quantity * p.price_per_kg) AS earnings
    FROM users u JOIN produce p ON p.farmer_id = u.id JOIN orders o ON o.produce_id = p.id
    WHERE o.status = 'delivered' AND u.role = 'farmer'
    GROUP BY u.id ORDER BY earnings DESC LIMIT 5
")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="margin: 0; background-color: #2E7D32; font-family: 'Segoe UI', sans-serif; min-height: 100vh;">
<div class="container py-4">
    <div style="background-color: #fff; border-radius: 12px; padding: 30px;">
        <h2 style="color: #2E7D32; font-weight: 600;" class="mb-4 text-center">📊 Admin Dashboard</h2>

        <div class="row g-3">
            <?php
            $cards = [
                ['👥 Users', $totalUsers],
                ['👨‍🌾 Farmers', $totalFarmers],
                ['🛒 Buyers', $totalBuyers],
                ['🥬 Produce Items', $totalProduce],
                ['📦 Orders', $totalOrders],
                ['💰 Revenue', '₹' . number_format($totalRevenue ?? 0, 2)],
            ];
            foreach ($cards as [$title, $value]) {
                echo <<<HTML
                <div class="col-md-4">
                    <div class="card text-center shadow-sm" style="border: none; border-left: 6px solid #2E7D32; transition: 0.3s ease;">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #555; font-size: 18px;">$title</h5>
                            <p class="card-text fw-bold" style="color: #2E7D32; font-size: 22px;">$value</p>
                        </div>
                    </div>
                </div>
                HTML;
            }
            ?>
        </div>

        <hr class="my-4">

        <div class="row">
            <div class="col-md-6 mb-4">
                <h4 style="color: #2E7D32;">📦 Order Status</h4>
                <canvas id="orderStatusChart" style="background-color: #fff; padding: 15px; border-radius: 10px;"></canvas>
            </div>
            <div class="col-md-6">
                <h4 style="color: #2E7D32;">🏆 Top Farmers by Revenue</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="farmerTable">
                        <thead style="background-color: #2E7D32; color: white;">
                            <tr><th>Farmer</th><th>Earnings</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topFarmers as $f): ?>
                                <tr>
                                    <td><?= htmlspecialchars($f['name']) ?></td>
                                    <td>₹<?= number_format($f['earnings'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <button onclick="exportTableToCSV()" class="btn btn-sm btn-outline-primary mt-2">📁 Export CSV</button>
                <button onclick="window.print()" class="btn btn-sm btn-outline-secondary mt-2">🖨️ Print / Save PDF</button>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between align-items-center">
            <a href="manage_users.php" class="btn btn-secondary" style="background-color: #2E7D32; border: none;">👥 Manage Users</a>
            <a href="logout.php" class="btn btn-danger" style="background-color: #c0392b; border: none;">🚪 Logout</a>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('orderStatusChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [<?php foreach ($orderStatus as $s) echo "'{$s['status']}',"; ?>],
        datasets: [{
            label: 'Orders',
            data: [<?php foreach ($orderStatus as $s) echo $s['count'] . ","; ?>],
            backgroundColor: ['#f39c12', '#3498db', '#2ecc71'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

function exportTableToCSV() {
    let csv = [];
    let rows = document.querySelectorAll("#farmerTable tr");
    for (let row of rows) {
        let cols = Array.from(row.querySelectorAll("td, th")).map(td => td.innerText);
        csv.push(cols.join(","));
    }
    const blob = new Blob([csv.join("\n")], { type: "text/csv" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "top_farmers.csv";
    a.click();
}
</script>
</body>
</html>
