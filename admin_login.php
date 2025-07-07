<?php
session_start();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email === "admin@localfarm.com" && $password === "admin123") {
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $message = "Invalid admin credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login | Local Farm Exchange</title>
</head>
<body>
    <h2>🔐 Admin Login</h2>
    <p style="color:red;"><?php echo $message; ?></p>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Admin Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <p>Back to <a href="index.php">Home</a></p>
</body>
</html>
