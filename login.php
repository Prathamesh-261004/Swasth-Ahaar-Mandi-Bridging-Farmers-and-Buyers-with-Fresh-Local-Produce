<?php
require_once 'db.php';
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    if ($email === "admin@localfarm.com" && $password === "admin123") {
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        header("Location: dashboard_" . $user['role'] . ".php");
        exit;
    } else {
        $message = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Swasth Ahaar Mandi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #2E7D32;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            color: #2E7D32;
            margin-bottom: 25px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            width: 100%;
            background-color: #2E7D32;
            color: #fff;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #25642a;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            color: #2E7D32;
            text-decoration: none;
        }

        .error {
            color: #d32f2f;
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }

        @media (max-width: 500px) {
            .login-box {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🔐 Login</h2>
        <?php if ($message): ?>
            <div class="error"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="link">
            No account? <a href="register.php">Register here</a>
        </div>
    </div>
</body>
</html>
