<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'farmer') {
    header("Location: login.php");
    exit;
}

require_once 'db.php';

// Fetch farmer's name
$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$farmer = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Farmer Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body style="margin: 0; background-color: #2E7D32; font-family: 'Segoe UI', sans-serif; min-height: 100vh;">
    <div class="container py-5">
        <div style="background-color: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); max-width: 600px; margin: auto;">
            <h2 class="text-center mb-4" style="color: #2E7D32;">👨‍🌾 Welcome, <?= htmlspecialchars($farmer['name']) ?>!</h2>

            <div class="list-group">
                <a href="add_produce.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    ➕ Add New Produce
                    <span class="badge bg-success">New</span>
                </a>
                <a href="orders.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    📦 View Orders
                    <span class="badge bg-warning text-dark">Orders</span>
                </a>
                <a href="earnings.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    💰 View Earnings & Ratings
                    <span class="badge bg-info text-dark">Stats</span>
                </a>
                <a href="logout.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center text-danger">
                    🚪 Logout
                </a>
            </div>
        </div>
    </div>
</body>
</html>
