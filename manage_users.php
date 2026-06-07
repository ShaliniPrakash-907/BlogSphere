<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$users = mysqli_query($conn, "SELECT * FROM users WHERE role='user' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users | BlogSphere</title>

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

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 18px;
            font-weight: 700;
        }

        .container {
            width: 90%;
            margin: 35px auto;
        }

        h1 {
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 20px;
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(20px);
        }

        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }

        th {
            color: #67e8f9;
        }

        td {
            color: #dbe4f0;
        }

        .delete-btn {
            text-decoration: none;
            padding: 9px 16px;
            border-radius: 20px;
            background: #ef4444;
            color: white;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">Blog<span>Sphere</span> Admin</div>

    <div class="nav-links">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <h1>Manage Users</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Joined Date</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($users)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <a href="delete_user.php?id=<?php echo $row['id']; ?>"
                       class="delete-btn"
                       onclick="return confirm('Delete this user? Their posts and comments will also be deleted.')">
                       Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>

</div>

</body>
</html>