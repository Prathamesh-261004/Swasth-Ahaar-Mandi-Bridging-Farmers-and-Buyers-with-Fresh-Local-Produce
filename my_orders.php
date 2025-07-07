<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit;
}
require_once 'db.php';

$stmt = $conn->prepare("
    SELECT orders.*, produce.name AS produce_name, produce.unit, produce.price_per_kg, users.name AS farmer_name
    FROM orders 
    JOIN produce ON orders.produce_id = produce.id
    JOIN users ON produce.farmer_id = users.id
    WHERE orders.buyer_id = ?
    ORDER BY orders.order_date DESC
");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #2E7D32; font-family: 'Segoe UI', sans-serif; margin: 0;">

<div class="container py-5">
    <div style="background-color: #fff; padding: 30px; border-radius: 12px; max-width: 900px; margin: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h2 class="text-center mb-4" style="color: #2E7D32;">📦 My Orders</h2>

        <?php if (count($orders) === 0): ?>
            <p class="text-muted text-center">You haven't placed any orders yet.</p>
        <?php endif; ?>

        <?php foreach ($orders as $order): ?>
            <div class="border rounded p-3 mb-4 shadow-sm">
                <h5 class="mb-1 text-success"><?= htmlspecialchars($order['produce_name']) ?></h5>
                <p class="mb-1"><strong>Farmer:</strong> <?= htmlspecialchars($order['farmer_name']) ?></p>
                <p class="mb-1"><strong>Quantity:</strong> <?= $order['quantity'] . ' ' . htmlspecialchars($order['unit']) ?></p>
                <p class="mb-1"><strong>Total Price:</strong> ₹<?= number_format($order['quantity'] * $order['price_per_kg'], 2) ?></p>
                <p class="mb-1"><strong>Status:</strong> 
                    <?php
                    $status = ucfirst($order['status']);
                    $badge = match($order['status']) {
                        'pending' => 'warning',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        default => 'secondary'
                    };
                    echo "<span class='badge bg-$badge'>$status</span>";
                    ?>
                </p>
                <p class="text-muted mb-0"><small>Ordered on <?= date('d M Y, H:i', strtotime($order['order_date'])) ?></small></p>
            </div>
        <?php endforeach; ?>

        <div class="text-center mt-4">
            <a href="dashboard_buyer.php" class="btn btn-outline-secondary">⬅ Back to Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>
