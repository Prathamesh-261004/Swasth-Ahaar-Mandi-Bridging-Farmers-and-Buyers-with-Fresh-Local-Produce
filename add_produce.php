<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'farmer') {
    header("Location: login.php");
    exit;
}
require_once 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = htmlspecialchars(trim($_POST['name']));
    $quantity = intval($_POST['quantity']);
    $unit     = htmlspecialchars(trim($_POST['unit']));
    $price    = floatval($_POST['price']);

    $stmt = $conn->prepare("INSERT INTO produce (farmer_id, name, quantity, unit, price_per_kg) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$_SESSION['user_id'], $name, $quantity, $unit, $price])) {
        $message = "✅ Produce added successfully!";
    } else {
        $message = "❌ Error adding produce.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Produce</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body style="margin: 0; background-color: #2E7D32; font-family: 'Segoe UI', sans-serif; min-height: 100vh;">
<div class="container py-5">
    <div style="background-color: #fff; padding: 30px; border-radius: 12px; max-width: 600px; margin: auto; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <h2 class="mb-4 text-center" style="color: #2E7D32;">➕ Add New Produce</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Produce Name" required>
            </div>
            <div class="mb-3">
                <input type="number" name="quantity" class="form-control" placeholder="Quantity" required>
            </div>
            <div class="mb-3">
                <input type="text" name="unit" class="form-control" placeholder="Unit (e.g. kg, bunch)" required>
            </div>
            <div class="mb-3">
                <input type="number" step="0.01" name="price" class="form-control" placeholder="Price per Kg" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success">✅ Add Produce</button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="dashboard_farmer.php" class="btn btn-outline-secondary">⬅ Back to Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>
