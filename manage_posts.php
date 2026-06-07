<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$posts = mysqli_query($conn,
"SELECT posts.*, users.name
 FROM posts
 JOIN users ON posts.user_id = users.id
 ORDER BY posts.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Posts | BlogSphere</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI',sans-serif;
        }

        body{
            min-height:100vh;
            color:white;

            background:
            radial-gradient(circle at top left,
            rgba(99,102,241,.7), transparent 32%),

            radial-gradient(circle at top right,
            rgba(236,72,153,.55), transparent 30%),

            linear-gradient(
            135deg,
            #020617,
            #111827,
            #1e1b4b);
        }

        .navbar{
            width:90%;
            margin:20px auto;
            padding:20px 30px;

            display:flex;
            justify-content:space-between;
            align-items:center;

            border-radius:20px;

            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.15);

            backdrop-filter:blur(15px);
        }

        .logo{
            font-size:28px;
            font-weight:900;
        }

        .logo span{
            color:#67e8f9;
        }

        .nav-links a{
            color:white;
            text-decoration:none;
            margin-left:18px;
            font-weight:700;
        }

        .container{
            width:90%;
            margin:30px auto;
        }

        h1{
            margin-bottom:25px;
        }

        .post-card{
            padding:25px;
            margin-bottom:20px;

            border-radius:25px;

            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.15);

            backdrop-filter:blur(20px);
        }

        .post-card h3{
            margin-bottom:10px;
        }

        .author{
            color:#67e8f9;
            margin-bottom:12px;
        }

        .content{
            color:#dbe4f0;
            line-height:1.7;
            margin-bottom:15px;
        }

        .date{
            color:#cbd5e1;
            font-size:14px;
            margin-bottom:15px;
        }

        .view-btn,
        .delete-btn{
            text-decoration:none;
            padding:10px 18px;
            border-radius:20px;
            font-size:14px;
            font-weight:700;
            margin-right:10px;
        }

        .view-btn{
            background:#22c55e;
            color:white;
        }

        .delete-btn{
            background:#ef4444;
            color:white;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">
        Blog<span>Sphere</span> Admin
    </div>

    <div class="nav-links">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_users.php">Users</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <h1>Manage Blog Posts</h1>

    <?php while($row=mysqli_fetch_assoc($posts)) { ?>

        <div class="post-card">

            <h3>
                <?php echo htmlspecialchars($row['title']); ?>
            </h3>

            <div class="author">
                By <?php echo htmlspecialchars($row['name']); ?>
            </div>

            <div class="content">
                <?php echo htmlspecialchars(substr($row['content'],0,250)); ?>...
            </div>

            <div class="date">
                <?php echo $row['created_at']; ?>
            </div>

            <a href="view_post.php?id=<?php echo $row['id']; ?>"
               class="view-btn">
               View
            </a>

            <a href="delete_admin_post.php?id=<?php echo $row['id']; ?>"
               class="delete-btn"
               onclick="return confirm('Delete this post?')">
               Delete
            </a>

        </div>

    <?php } ?>

</div>

</body>
</html>