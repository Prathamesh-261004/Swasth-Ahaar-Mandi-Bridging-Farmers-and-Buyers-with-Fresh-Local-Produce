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
    <title>Manage Users</title>
</head>
<body>
    <h2>👥 All Registered Users</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Registered On</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= ucfirst($user['role']) ?></td>
                <td><?= $user['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="admin_dashboard.php">⬅ Back to Dashboard</a></p>
</body>
</html>
