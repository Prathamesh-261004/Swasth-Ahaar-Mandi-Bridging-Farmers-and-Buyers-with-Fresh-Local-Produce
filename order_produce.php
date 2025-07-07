<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit;
}
require_once 'db.php';

// Handle order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produce_id = intval($_POST['produce_id']);
    $quantity = intval($_POST['quantity']);

    $stmt = $conn->prepare("INSERT INTO orders (buyer_id, produce_id, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $produce_id, $quantity]);
}

// Fetch produce
$produceList = $conn->query("
    SELECT produce.*, users.name AS farmer_name 
    FROM produce 
    JOIN users ON produce.farmer_id = users.id
    ORDER BY produce.created_at DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Produce</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #2E7D32; font-family: 'Segoe UI', sans-serif; margin: 0;">

<div class="container py-5">
    <div style="background-color: #fff; padding: 30px; border-radius: 12px; max-width: 900px; margin: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h2 class="text-center mb-4" style="color: #2E7D32;">🛒 Browse & Order Produce</h2>

        <?php if (count($produceList) === 0): ?>
            <p class="text-muted text-center">No produce available right now.</p>
        <?php endif; ?>

        <?php foreach ($produceList as $item): ?>
            <div class="border rounded p-3 mb-4 shadow-sm">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="text-success mb-1"><?= htmlspecialchars($item['name']) ?></h5>
                        <p class="mb-1"><strong>Farmer:</strong> <?= htmlspecialchars($item['farmer_name']) ?></p>
                        <p class="mb-1"><strong>Available:</strong> <?= $item['quantity'] . ' ' . htmlspecialchars($item['unit']) ?></p>
                        <p class="mb-2"><strong>Price:</strong> ₹<?= $item['price_per_kg'] ?>/kg</p>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <form method="POST" class="w-100 d-flex gap-2">
                            <input type="hidden" name="produce_id" value="<?= $item['id'] ?>">
                            <input type="number" name="quantity" min="1" max="<?= $item['quantity'] ?>" class="form-control form-control-sm" placeholder="Qty" required>
                            <button type="submit" class="btn btn-sm btn-outline-success">Order</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="text-center mt-4">
            <a href="dashboard_buyer.php" class="btn btn-outline-secondary">⬅ Back to Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>
