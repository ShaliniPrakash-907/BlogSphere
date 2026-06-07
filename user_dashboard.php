<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$posts = mysqli_query($conn,
"SELECT * FROM posts
 WHERE user_id = '$user_id'
 ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard | BlogSphere</title>

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
            radial-gradient(circle at top left, rgba(99,102,241,.7), transparent 32%),
            radial-gradient(circle at top right, rgba(236,72,153,.55), transparent 30%),
            linear-gradient(135deg, #020617, #111827, #1e1b4b);
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

        .logout-btn{
            text-decoration:none;
            color:white;
            padding:12px 22px;
            border-radius:30px;
            background:rgba(255,255,255,.1);
        }

        .container{
            width:90%;
            margin:30px auto;
        }

        .welcome-box{
            padding:35px;
            border-radius:30px;
            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.15);
            backdrop-filter:blur(20px);
        }

        .welcome-box h1{
            font-size:40px;
            margin-bottom:10px;
        }

        .welcome-box p{
            color:#dbe4f0;
        }

        .create-btn{
            display:inline-block;
            margin-top:20px;
            padding:14px 25px;
            text-decoration:none;
            font-weight:700;
            color:#020617;
            border-radius:30px;
            background:linear-gradient(135deg, #67e8f9, #818cf8);
        }

        .section-title{
            margin:40px 0 20px;
            font-size:28px;
        }

        .post-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
            gap:25px;
        }

        .post-card{
            padding:25px;
            border-radius:25px;
            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.15);
            backdrop-filter:blur(20px);
        }

        .post-card h3{
            margin-bottom:10px;
        }

        .post-card p{
            color:#dbe4f0;
            line-height:1.6;
        }

        .post-date{
            margin-top:12px;
            color:#67e8f9;
            font-size:14px;
        }

        .actions{
            margin-top:20px;
            display:flex;
            flex-wrap:wrap;
            gap:10px;
        }

        .view-btn,
        .edit-btn,
        .delete-btn{
            text-decoration:none;
            padding:10px 18px;
            border-radius:20px;
            font-size:14px;
            font-weight:700;
        }

        .view-btn{
            background:#22c55e;
            color:white;
        }

        .edit-btn{
            background:#67e8f9;
            color:#020617;
        }

        .delete-btn{
            background:#ef4444;
            color:white;
        }

        .empty{
            padding:40px;
            text-align:center;
            border-radius:25px;
            background:rgba(255,255,255,.08);
        }
    </style>

</head>
<body>

<div class="navbar">
    <div class="logo">
        Blog<span>Sphere</span>
    </div>

    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<div class="container">

    <div class="welcome-box">
        <h1>
            Welcome, <?php echo htmlspecialchars($user_name); ?>
        </h1>

        <p>
            Manage your blogs and create new posts.
        </p>

        <a href="create_post.php" class="create-btn">
           + Create New Blog
        </a>
    </div>

    <h2 class="section-title">My Blog Posts</h2>

    <?php if(mysqli_num_rows($posts)>0) { ?>

        <div class="post-grid">

            <?php while($row=mysqli_fetch_assoc($posts)) { ?>

                <div class="post-card">

                    <h3>
                        <?php echo htmlspecialchars($row['title']); ?>
                    </h3>

                    <p>
                        <?php echo htmlspecialchars(substr($row['content'],0,150)); ?>...
                    </p>

                    <div class="post-date">
                        <?php echo $row['created_at']; ?>
                    </div>

                    <div class="actions">

                        <a href="view_post.php?id=<?php echo $row['id']; ?>" class="view-btn">
                            View
                        </a>

                        <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="edit-btn">
                            Edit
                        </a>

                        <a href="delete_post.php?id=<?php echo $row['id']; ?>"
                           class="delete-btn"
                           onclick="return confirm('Delete this post?')">
                            Delete
                        </a>

                    </div>

                </div>

            <?php } ?>

        </div>

    <?php } else { ?>

        <div class="empty">
            <h3>No Blog Posts Yet</h3>
            <br>
            <p>Create your first blog post.</p>
        </div>

    <?php } ?>

</div>

</body>
</html>