<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'farmer') {
    header("Location: login.php");
    exit;
}
require_once 'db.php';

$farmer_id = $_SESSION['user_id'];

// Total earnings calculation
$earningsQuery = $conn->prepare("
    SELECT SUM(o.quantity * p.price_per_kg) AS total_earnings
    FROM orders o
    JOIN produce p ON o.produce_id = p.id
    WHERE p.farmer_id = ? AND o.status = 'delivered'
");
$earningsQuery->execute([$farmer_id]);
$earnings = $earningsQuery->fetch()['total_earnings'] ?? 0;

// Average rating calculation
$ratingQuery = $conn->prepare("SELECT AVG(rating) AS avg_rating FROM ratings WHERE farmer_id = ?");
$ratingQuery->execute([$farmer_id]);
$avg_rating = round($ratingQuery->fetch()['avg_rating'], 1) ?? 'N/A';

// Feedback list
$feedbacks = $conn->prepare("
    SELECT r.rating, r.feedback, u.name AS buyer_name, r.created_at
    FROM ratings r
    JOIN users u ON r.buyer_id = u.id
    WHERE r.farmer_id = ?
    ORDER BY r.created_at DESC
");
$feedbacks->execute([$farmer_id]);
$feedbackList = $feedbacks->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Farmer Earnings & Ratings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #2E7D32; margin: 0; font-family: 'Segoe UI', sans-serif;">

<div class="container py-5">
    <div style="background-color: #fff; padding: 30px; border-radius: 12px; max-width: 800px; margin: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h2 class="text-center mb-4" style="color: #2E7D32;">💰 Your Earnings & Ratings</h2>

        <div class="mb-4 text-center">
            <h5>Total Earnings: <span class="text-success fw-bold">₹<?= number_format($earnings, 2) ?></span></h5>
            <h6>Average Rating: <span class="text-warning"><?= $avg_rating ?> ⭐</span></h6>
        </div>

        <h4 class="mb-3">📝 Recent Feedback</h4>
        <?php if (count($feedbackList) === 0): ?>
            <p class="text-muted">No feedback yet.</p>
        <?php endif; ?>

        <?php foreach ($feedbackList as $fb): ?>
            <div class="border rounded p-3 mb-3 shadow-sm">
                <strong><?= htmlspecialchars($fb['buyer_name']) ?></strong> rated you 
                <span class="text-warning"><?= $fb['rating'] ?> ⭐</span><br>
                <em class="text-muted">"<?= htmlspecialchars($fb['feedback']) ?>"</em><br>
                <small class="text-secondary"><?= date('d M Y, h:i A', strtotime($fb['created_at'])) ?></small>
            </div>
        <?php endforeach; ?>

        <div class="text-center mt-4">
            <a href="dashboard_farmer.php" class="btn btn-outline-secondary">⬅ Back to Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>
