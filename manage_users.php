<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
require_once 'db.php';

$users = $conn->query("SELECT * FROM users ORDER BY role, created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users | Swasth Ahaar Mandi</title>
    <meta charset="UTF-8">
</head>
<body style="margin:0; font-family:Segoe UI,sans-serif; background-color:#2E7D32; color:#fff;">

<div style="max-width:1000px; margin:40px auto; background:#fff; color:#000; padding:30px; border-radius:12px; box-shadow:0 0 10px rgba(0,0,0,0.2);">
    <h2 style="color:#2E7D32; text-align:center;">👥 All Registered Users</h2>

    <table style="width:100%; border-collapse:collapse; margin-top:20px;">
        <thead>
            <tr style="background-color:#f1f1f1; color:#2E7D32;">
                <th style="border:1px solid #ccc; padding:10px;">ID</th>
                <th style="border:1px solid #ccc; padding:10px;">Name</th>
                <th style="border:1px solid #ccc; padding:10px;">Email</th>
                <th style="border:1px solid #ccc; padding:10px;">Role</th>
                <th style="border:1px solid #ccc; padding:10px;">Registered On</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr style="text-align:center;">
                <td style="border:1px solid #ccc; padding:10px;"><?= $user['id'] ?></td>
                <td style="border:1px solid #ccc; padding:10px;"><?= htmlspecialchars($user['name']) ?></td>
                <td style="border:1px solid #ccc; padding:10px;"><?= htmlspecialchars($user['email']) ?></td>
                <td style="border:1px solid #ccc; padding:10px;"><?= ucfirst($user['role']) ?></td>
                <td style="border:1px solid #ccc; padding:10px;"><?= $user['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top:20px; text-align:right;">
        <a href="admin_dashboard.php" style="background:#2E7D32; color:#fff; text-decoration:none; padding:10px 20px; border-radius:6px;">⬅ Back to Dashboard</a>
    </div>
</div>

</body>
</html>
