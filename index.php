<?php
include 'db.php';

$totalPosts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM posts"))['total'];
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='user'"))['total'];
$totalComments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM comments"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>BlogSphere</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            height: 100vh;
            overflow: hidden;
            color: white;
            background:
                radial-gradient(circle at top left, rgba(99,102,241,0.7), transparent 32%),
                radial-gradient(circle at top right, rgba(236,72,153,0.55), transparent 30%),
                linear-gradient(135deg, #020617, #111827, #1e1b4b);
        }

        .navbar {
            width: 90%;
            height: 76px;
            margin: 22px auto 0;
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 22px;
            background: rgba(255,255,255,0.09);
            border: 1px solid rgba(255,255,255,0.16);
            backdrop-filter: blur(18px);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
        }

        .logo {
            font-size: 28px;
            font-weight: 900;
        }

        .logo span {
            color: #67e8f9;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 24px;
            font-weight: 700;
        }

        .navbar a:hover {
            color: #67e8f9;
        }

        .main-container {
            width: 90%;
            height: calc(100vh - 120px);
            margin: 0 auto;
            display: flex;
            align-items: center;
        }

        .hero {
            width: 100%;
            display: grid;
            grid-template-columns: 1.45fr 0.65fr;
            gap: 32px;
        }

        .hero-content,
        .overview-card {
            border-radius: 32px;
            background: rgba(255,255,255,0.09);
            border: 1px solid rgba(255,255,255,0.16);
            backdrop-filter: blur(20px);
            box-shadow: 0 24px 60px rgba(0,0,0,0.38);
        }

        .hero-content {
            padding: 52px;
        }

        .tag {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 30px;
            background: rgba(103,232,249,0.16);
            color: #67e8f9;
            font-weight: 900;
            font-size: 14px;
        }

        h1 {
            max-width: 760px;
            margin: 22px 0;
            font-size: 56px;
            line-height: 1.08;
        }

        .hero-content p {
            max-width: 700px;
            color: #dbe4f0;
            font-size: 18px;
            line-height: 1.7;
        }

        .features {
            margin-top: 24px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .features span {
            padding: 10px 16px;
            border-radius: 25px;
            color: #dffcff;
            background: rgba(103,232,249,0.13);
            font-weight: 700;
            font-size: 14px;
        }

        .buttons {
            margin-top: 34px;
        }

        .btn {
            display: inline-block;
            padding: 14px 28px;
            margin-right: 14px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 900;
        }

        .primary {
            color: #020617;
            background: linear-gradient(135deg, #67e8f9, #818cf8);
        }

        .secondary {
            color: white;
            border: 1px solid rgba(255,255,255,0.35);
            background: rgba(255,255,255,0.08);
        }

        .overview-card {
            padding: 32px;
        }

        .overview-card h2 {
            font-size: 28px;
            margin-bottom: 24px;
        }

        .stat {
            padding: 18px;
            margin-bottom: 18px;
            border-radius: 20px;
            background: rgba(255,255,255,0.09);
        }

        .stat h3 {
            font-size: 40px;
            color: #67e8f9;
        }

        .stat p {
            color: #dbe4f0;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">Blog<span>Sphere</span></div>

    <div>
        <a href="index.php">Home</a>
        <a href="admin_login.php">Admin Login</a>
        <a href="user_login.php">User Login</a>
    </div>
</div>

<div class="main-container">
    <div class="hero">

        <div class="hero-content">
            <span class="tag">Role Based Blog Platform</span>

            <h1>Write blogs. Share ideas. Manage content.</h1>

            <p>
                A modern PHP and MySQL blogging platform with user login,
                admin control, blog posts, and comments.
            </p>

            <div class="features">
                <span>Authentication</span>
                <span>Blog CRUD</span>
                <span>Comments</span>
                <span>Admin Panel</span>
            </div>

            <div class="buttons">
                <a href="user_login.php" class="btn primary">Continue as User</a>
                <a href="admin_login.php" class="btn secondary">Continue as Admin</a>
            </div>
        </div>

        <div class="overview-card">
            <h2>Platform Overview</h2>

            <div class="stat">
                <h3><?php echo $totalPosts; ?></h3>
                <p>Blog Posts</p>
            </div>

            <div class="stat">
                <h3><?php echo $totalUsers; ?></h3>
                <p>Users</p>
            </div>

            <div class="stat">
                <h3><?php echo $totalComments; ?></h3>
                <p>Comments</p>
            </div>
        </div>

    </div>
</div>

</body>
</html>