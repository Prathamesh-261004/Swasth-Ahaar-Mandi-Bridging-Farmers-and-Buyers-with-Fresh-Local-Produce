<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'farmer') {
    header("Location: login.php");
    exit;
}
require_once 'db.php';

$farmer_id = $_SESSION['user_id'];

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ? AND produce_id IN (SELECT id FROM produce WHERE farmer_id = ?)");
    $stmt->execute([$new_status, $order_id, $farmer_id]);
}

// Fetch orders for farmer
$stmt = $conn->prepare("
    SELECT orders.*, users.name AS buyer_name, produce.name AS produce_name 
    FROM orders 
    JOIN produce ON orders.produce_id = produce.id 
    JOIN users ON orders.buyer_id = users.id 
    WHERE produce.farmer_id = ?
    ORDER BY orders.order_date DESC
");
$stmt->execute([$farmer_id]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Farmer Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #2E7D32; margin: 0; font-family: 'Segoe UI', sans-serif;">

<div class="container py-5">
    <div style="background-color: #fff; padding: 30px; border-radius: 12px; max-width: 800px; margin: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h2 class="mb-4 text-center" style="color: #2E7D32;">📦 Orders on Your Produce</h2>

        <?php if (count($orders) === 0): ?>
            <p class="text-muted text-center">No orders yet.</p>
        <?php endif; ?>

        <?php foreach ($orders as $order): ?>
            <div class="border rounded p-3 mb-3 shadow-sm">
                <h5 class="text-success"><?= htmlspecialchars($order['produce_name']) ?></h5>
                <p class="mb-1"><strong>Buyer:</strong> <?= htmlspecialchars($order['buyer_name']) ?></p>
                <p class="mb-1"><strong>Quantity:</strong> <?= $order['quantity'] ?></p>
                <p class="mb-1"><strong>Status:</strong> <span class="text-primary"><?= ucfirst($order['status']) ?></span></p>
                <p class="mb-2"><strong>Order Date:</strong> <?= $order['order_date'] ?></p>

                <form method="POST" class="d-flex align-items-center gap-2">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <select name="status" class="form-select form-select-sm" style="max-width: 160px;">
                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-outline-success">Update Status</button>
                </form>
            </div>
        <?php endforeach; ?>

        <div class="text-center mt-4">
            <a href="dashboard_farmer.php" class="btn btn-outline-secondary">⬅ Back to Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>
