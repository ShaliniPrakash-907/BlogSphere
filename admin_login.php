<?php
session_start();
include 'db.php';

$message = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND role='admin'");

    if (mysqli_num_rows($query) == 1) {
        $admin = mysqli_fetch_assoc($query);

        if (password_verify($password, $admin['password']) || $password == $admin['password']) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['role'] = $admin['role'];

            header("Location: admin_dashboard.php");
            exit();
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "Admin account not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login | BlogSphere</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            height: 100vh;
            color: white;
            background:
                radial-gradient(circle at top left, rgba(99,102,241,0.7), transparent 32%),
                radial-gradient(circle at top right, rgba(236,72,153,0.55), transparent 30%),
                linear-gradient(135deg, #020617, #111827, #1e1b4b);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-page {
            width: 90%;
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 40px;
            align-items: center;
        }

        .logo {
            font-size: 30px;
            font-weight: 900;
            margin-bottom: 35px;
        }

        .logo span {
            color: #67e8f9;
        }

        .auth-left h1 {
            max-width: 650px;
            font-size: 54px;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .auth-left p {
            max-width: 620px;
            color: #dbe4f0;
            font-size: 18px;
            line-height: 1.7;
        }

        .auth-box {
            width: 420px;
            padding: 40px;
            border-radius: 30px;
            text-align: center;
            background: rgba(255,255,255,0.09);
            border: 1px solid rgba(255,255,255,0.16);
            backdrop-filter: blur(20px);
            box-shadow: 0 24px 60px rgba(0,0,0,0.38);
        }

        .auth-box h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .auth-box p {
            color: #dbe4f0;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 14px 18px;
            margin-bottom: 16px;
            border: none;
            outline: none;
            border-radius: 14px;
            color: white;
            background: rgba(255,255,255,0.12);
        }

        input::placeholder {
            color: #cbd5e1;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 30px;
            color: #020617;
            font-weight: 900;
            cursor: pointer;
            background: linear-gradient(135deg, #67e8f9, #818cf8);
        }

        .back-link {
            display: inline-block;
            margin-top: 18px;
            color: #67e8f9;
            text-decoration: none;
            font-weight: 700;
        }

        .message {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 12px;
            background: rgba(239,68,68,0.18);
            color: #fecaca;
        }
    </style>
</head>
<body>

<div class="auth-page">
    <div class="auth-left">
        <div class="logo">Blog<span>Sphere</span></div>
        <h1>Admin control starts here.</h1>
        <p>Login to manage users, blog posts, comments, and platform content.</p>
    </div>

    <div class="auth-box">
        <h2>Admin Login</h2>
        <p>Access admin dashboard</p>

        <?php if ($message != "") { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Enter admin email" required>
            <input type="password" name="password" placeholder="Enter password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <a href="index.php" class="back-link">Back to Home</a>
    </div>
</div>

</body>
</html>