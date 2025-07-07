<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

// Fetch buyer's name
$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$buyer = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buyer Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="margin: 0; background-color: #2E7D32; font-family: 'Segoe UI', sans-serif; min-height: 100vh;">

<div class="container py-5">
    <div style="background-color: #fff; padding: 30px; border-radius: 12px; max-width: 600px; margin: auto; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <h2 class="text-center mb-4" style="color: #2E7D32;">🛒 Welcome, <?= htmlspecialchars($buyer['name']) ?>!</h2>

        <div class="list-group">
            <a href="order_produce.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                🛍️ Browse & Order Produce
                <span class="badge bg-success">Fresh</span>
            </a>
            <a href="my_orders.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                📦 My Orders
                <span class="badge bg-warning text-dark">Track</span>
            </a>
            <a href="rating.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                ⭐ Rate Farmers
                <span class="badge bg-info text-dark">Feedback</span>
            </a>
            <a href="logout.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center text-danger">
                🚪 Logout
            </a>
        </div>
    </div>
</div>

</body>
</html>
