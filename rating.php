<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit;
}
require_once 'db.php';

$buyer_id = $_SESSION['user_id'];

// Handle rating submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $farmer_id = intval($_POST['farmer_id']);
    $rating = intval($_POST['rating']);
    $feedback = htmlspecialchars(trim($_POST['feedback']));

    // Avoid duplicate rating
    $check = $conn->prepare("SELECT id FROM ratings WHERE buyer_id = ? AND farmer_id = ?");
    $check->execute([$buyer_id, $farmer_id]);

    if ($check->rowCount() == 0 && $rating >= 1 && $rating <= 5) {
        $stmt = $conn->prepare("INSERT INTO ratings (farmer_id, buyer_id, rating, feedback) VALUES (?, ?, ?, ?)");
        $stmt->execute([$farmer_id, $buyer_id, $rating, $feedback]);
        $msg = "Thanks for rating!";
    } else {
        $msg = "You already rated this farmer or input is invalid.";
    }
}

// List farmers the buyer has ordered from (delivered only)
$farmerList = $conn->prepare("
    SELECT DISTINCT u.id, u.name
    FROM users u
    JOIN produce p ON p.farmer_id = u.id
    JOIN orders o ON o.produce_id = p.id
    WHERE o.buyer_id = ? AND o.status = 'delivered'
    ORDER BY u.name
");
$farmerList->execute([$buyer_id]);
$farmers = $farmerList->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rate Farmers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #2E7D32; font-family: 'Segoe UI', sans-serif; margin: 0;">

<div class="container py-5">
    <div style="background-color: #fff; padding: 30px; border-radius: 12px; max-width: 850px; margin: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h2 class="text-center mb-4" style="color: #2E7D32;">⭐ Rate Your Farmers</h2>

        <?php if (isset($msg)): ?>
            <div class="alert alert-info text-center"><?= $msg ?></div>
        <?php endif; ?>

        <?php if (count($farmers) === 0): ?>
            <p class="text-muted text-center">No farmers available to rate. (Only delivered orders are eligible)</p>
        <?php endif; ?>

        <?php foreach ($farmers as $farmer): ?>
            <form method="POST" class="mb-4 border rounded p-3 shadow-sm">
                <h5 class="text-success"><?= htmlspecialchars($farmer['name']) ?></h5>
                <input type="hidden" name="farmer_id" value="<?= $farmer['id'] ?>">
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="rating<?= $farmer['id'] ?>" class="form-label">Rating (1–5)</label>
                        <input type="number" class="form-control" id="rating<?= $farmer['id'] ?>" name="rating" min="1" max="5" required>
                    </div>
                    <div class="col-md-9">
                        <label for="feedback<?= $farmer['id'] ?>" class="form-label">Feedback</label>
                        <textarea name="feedback" id="feedback<?= $farmer['id'] ?>" rows="3" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-outline-success">Submit Rating</button>
                </div>
            </form>
        <?php endforeach; ?>

        <div class="text-center mt-4">
            <a href="dashboard_buyer.php" class="btn btn-outline-secondary">⬅ Back to Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>
