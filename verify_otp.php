<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['otp']) || !isset($_SESSION['reg_data'])) {
    header("Location: register.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputOtp = intval($_POST['otp']);
    if ($inputOtp === $_SESSION['otp']) {
        $data = $_SESSION['reg_data'];
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$data['name'], $data['email'], $data['password'], $data['role']])) {
            $message = "✅ Registration successful! <a href='login.php'>Login here</a>.";
            unset($_SESSION['otp']);
            unset($_SESSION['reg_data']);
        } else {
            $message = "❌ Registration failed!";
        }
    } else {
        $message = "⚠️ Invalid OTP!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <style>
        body {
            background-color: #2E7D32;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        input {
            padding: 10px;
            width: 80%;
            margin: 15px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 25px;
            background: #2E7D32;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .msg {
            color: red;
        }
    </style>
</head>
<body>
<div class="box">
    <h2>🔐 OTP Verification</h2>
    <?php if ($message): ?>
        <p class="msg"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="number" name="otp" placeholder="Enter OTP" required><br>
        <button type="submit">Verify</button>
    </form>
</div>
</body>
</html>
