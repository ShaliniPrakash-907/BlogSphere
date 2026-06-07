<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='user'"))['total'];
$totalPosts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM posts"))['total'];
$totalComments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM comments"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | BlogSphere</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            min-height: 100vh;
            color: white;
            background:
            radial-gradient(circle at top left, rgba(99,102,241,.7), transparent 32%),
            radial-gradient(circle at top right, rgba(236,72,153,.55), transparent 30%),
            linear-gradient(135deg, #020617, #111827, #1e1b4b);
        }

        .navbar {
            width: 90%;
            margin: 22px auto;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 22px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.15);
            backdrop-filter: blur(18px);
        }

        .logo {
            font-size: 28px;
            font-weight: 900;
        }

        .logo span {
            color: #67e8f9;
        }

        .logout {
            color: white;
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 30px;
            background: rgba(255,255,255,.1);
            font-weight: 700;
        }

        .container {
            width: 90%;
            margin: 35px auto;
        }

        .welcome {
            padding: 35px;
            border-radius: 30px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.15);
            backdrop-filter: blur(20px);
            margin-bottom: 35px;
        }

        .welcome h1 {
            font-size: 42px;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #dbe4f0;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 35px;
        }

        .stat-card {
            padding: 30px;
            border-radius: 25px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.15);
            backdrop-filter: blur(20px);
        }

        .stat-card h2 {
            font-size: 42px;
            color: #67e8f9;
            margin-bottom: 8px;
        }

        .stat-card p {
            color: #dbe4f0;
        }

        .admin-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
        }

        .action-card {
            padding: 30px;
            border-radius: 25px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.15);
            backdrop-filter: blur(20px);
        }

        .action-card h3 {
            font-size: 25px;
            margin-bottom: 12px;
        }

        .action-card p {
            color: #dbe4f0;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .action-card a {
            display: inline-block;
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 30px;
            color: #020617;
            font-weight: 800;
            background: linear-gradient(135deg, #67e8f9, #818cf8);
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">Blog<span>Sphere</span> Admin</div>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">

    <div class="welcome">
        <h1>Welcome, Admin</h1>
        <p>Manage users, blog posts and comments from one place.</p>
    </div>

    <div class="stats">
        <div class="stat-card">
            <h2><?php echo $totalUsers; ?></h2>
            <p>Total Users</p>
        </div>

        <div class="stat-card">
            <h2><?php echo $totalPosts; ?></h2>
            <p>Total Blog Posts</p>
        </div>

        <div class="stat-card">
            <h2><?php echo $totalComments; ?></h2>
            <p>Total Comments</p>
        </div>
    </div>

    <div class="admin-actions">

        <div class="action-card">
            <h3>Manage Users</h3>
            <p>View all registered users and remove users if needed.</p>
            <a href="manage_users.php">Open Users</a>
        </div>

        <div class="action-card">
            <h3>Manage Posts</h3>
            <p>View and delete blog posts created by users.</p>
            <a href="manage_posts.php">Open Posts</a>
        </div>

        <div class="action-card">
            <h3>Manage Comments</h3>
            <p>View and delete inappropriate or unwanted comments.</p>
            <a href="manage_comments.php">Open Comments</a>
        </div>

    </div>

</div>

</body>
</html>