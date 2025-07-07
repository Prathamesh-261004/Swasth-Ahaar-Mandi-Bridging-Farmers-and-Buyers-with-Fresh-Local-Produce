<?php
session_start();
require_once 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // composer require phpmailer/phpmailer

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = htmlspecialchars(trim($_POST['name']));
    $email    = htmlspecialchars(trim($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role     = $_POST['role'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $message = "Email already registered!";
    } else {
        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['reg_data'] = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ];

        // Send OTP email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Change to your SMTP
            $mail->SMTPAuth   = true;
         $mail->Username   = 'your_email@gmail.com';
            $mail->Password   = 'your_email_password'; // App password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('your_email@gmail.com', 'Swasth Ahaar Mandi');
$mail->addAddress($email, $name);
$mail->isHTML(true); // Enable HTML content
$mail->Subject = 'Swasth Ahaar Mandi | Your OTP for Secure Registration';

// Generate styled HTML body
$mail->Body = "
<html>
<head>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f4;
      color: #333;
    }
    .container {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .header {
      text-align: center;
      color: #2E7D32;
    }
    .otp-box {
      background-color: #E8F5E9;
      color: #1B5E20;
      padding: 20px;
      font-size: 24px;
      text-align: center;
      font-weight: bold;
      border-radius: 8px;
      margin: 20px 0;
      letter-spacing: 4px;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #999;
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <div class='container'>
    <h2 class='header'>🌱 Welcome to <span style='color:#1B5E20;'>Swasth Ahaar Mandi</span></h2>
    <p>Hello <strong>" . htmlspecialchars($name) . "</strong>,</p>
    <p>We're thrilled to have you join our local and sustainable marketplace for fresh produce.</p>
    
    <p>To complete your registration, please use the following One-Time Password (OTP):</p>
    
    <div class='otp-box'>$otp</div>
    
    <p>This OTP is valid for the next <strong>10 minutes</strong>. Do not share it with anyone.</p>
    
    <p>If you didn’t initiate this request, you can safely ignore this email.</p>
    
    <div class='footer'>
      🚜 Empowering Farmers | 🛒 Serving Buyers | 🌿 Building Healthier Communities<br>
      &copy; " . date('Y') . " Swasth Ahaar Mandi
    </div>
  </div>
</body>
</html>
";


            $mail->send();
            header('Location: verify_otp.php');
            exit;
        } catch (Exception $e) {
            $message = "OTP Email could not be sent.";
        }
    }
}
?>
<!-- HTML part remains same as your above UI -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Swasth Ahaar Mandi</title>
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

        .register-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            color: #2E7D32;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .radio-group {
            margin-bottom: 20px;
        }

        .radio-group label {
            display: block;
            margin: 6px 0;
            font-size: 15px;
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

        .message {
            color: #d32f2f;
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }

        @media (max-width: 500px) {
            .register-box {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>📝 Register</h2>
        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <div class="radio-group">
                <label>Register as:</label>
                <label><input type="radio" name="role" value="farmer" required> 👨‍🌾 Farmer</label>
                <label><input type="radio" name="role" value="buyer" required> 🛒 Buyer</label>
            </div>

            <button type="submit">Register</button>
        </form>
        <div class="link">
            Already registered? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>
