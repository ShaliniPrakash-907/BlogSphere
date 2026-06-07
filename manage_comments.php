<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$comments = mysqli_query($conn,
"SELECT comments.*, users.name, posts.title
 FROM comments
 JOIN users ON comments.user_id = users.id
 JOIN posts ON comments.post_id = posts.id
 ORDER BY comments.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Comments | BlogSphere</title>

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

        .comment-card{
            padding:25px;
            margin-bottom:20px;

            border-radius:25px;

            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.15);

            backdrop-filter:blur(20px);
        }

        .user{
            color:#67e8f9;
            font-weight:700;
            margin-bottom:8px;
        }

        .post-title{
            color:#cbd5e1;
            margin-bottom:12px;
        }

        .comment{
            line-height:1.7;
            color:#dbe4f0;
            margin-bottom:15px;
        }

        .date{
            font-size:14px;
            color:#cbd5e1;
            margin-bottom:15px;
        }

        .delete-btn{
            text-decoration:none;
            padding:10px 18px;
            border-radius:20px;
            background:#ef4444;
            color:white;
            font-weight:700;
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
        <a href="manage_posts.php">Posts</a>
        <a href="logout.php">Logout</a>
    </div>

</div>

<div class="container">

    <h1>Manage Comments</h1>

    <?php while($row=mysqli_fetch_assoc($comments)) { ?>

        <div class="comment-card">

            <div class="user">
                <?php echo htmlspecialchars($row['name']); ?>
            </div>

            <div class="post-title">
                Blog: <?php echo htmlspecialchars($row['title']); ?>
            </div>

            <div class="comment">
                <?php echo nl2br(htmlspecialchars($row['comment'])); ?>
            </div>

            <div class="date">
                <?php echo $row['created_at']; ?>
            </div>

            <a href="delete_comment.php?id=<?php echo $row['id']; ?>"
               class="delete-btn"
               onclick="return confirm('Delete this comment?')">
               Delete Comment
            </a>

        </div>

    <?php } ?>

</div>

</body>
</html>