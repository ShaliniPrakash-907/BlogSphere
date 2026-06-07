<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$post_id = mysqli_real_escape_string($conn, $_GET['id']);

$postQuery = mysqli_query($conn,
"SELECT posts.*, users.name
 FROM posts
 JOIN users ON posts.user_id = users.id
 WHERE posts.id='$post_id'");

if (mysqli_num_rows($postQuery) == 0) {
    echo "Post not found";
    exit();
}

$post = mysqli_fetch_assoc($postQuery);

$message = "";

if (isset($_POST['add_comment'])) {

    if (!isset($_SESSION['user_id'])) {
        $message = "Please login as user to comment.";
    } else {
        $user_id = $_SESSION['user_id'];

        $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id' AND role='user'");

        if (mysqli_num_rows($checkUser) == 0) {
            $message = "Invalid user session. Please login again.";
        } else {
            $comment = mysqli_real_escape_string($conn, $_POST['comment']);

            if (!empty($comment)) {
                $insert = "INSERT INTO comments (post_id, user_id, comment)
                           VALUES ('$post_id', '$user_id', '$comment')";

                if (mysqli_query($conn, $insert)) {
                    header("Location: view_post.php?id=$post_id");
                    exit();
                } else {
                    $message = "Comment failed.";
                }
            }
        }
    }
}

$comments = mysqli_query($conn,
"SELECT comments.*, users.name
 FROM comments
 JOIN users ON comments.user_id = users.id
 WHERE comments.post_id='$post_id'
 ORDER BY comments.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($post['title']); ?></title>

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

        .container {
            width: 85%;
            max-width: 1000px;
            margin: 40px auto;
        }

        .card {
            padding: 35px;
            border-radius: 30px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.15);
            backdrop-filter: blur(20px);
            margin-bottom: 30px;
        }

        h1 {
            margin-bottom: 15px;
            font-size: 40px;
        }

        .author {
            color: #67e8f9;
            margin-bottom: 25px;
        }

        .content {
            line-height: 1.9;
            color: #dbe4f0;
            white-space: pre-wrap;
        }

        h2 {
            margin-bottom: 20px;
        }

        textarea {
            width: 100%;
            min-height: 120px;
            padding: 15px;
            margin-bottom: 15px;
            border: none;
            outline: none;
            border-radius: 15px;
            color: white;
            background: rgba(255,255,255,.1);
        }

        textarea::placeholder {
            color: #cbd5e1;
        }

        button {
            padding: 12px 25px;
            border: none;
            cursor: pointer;
            border-radius: 30px;
            font-weight: 800;
            color: #020617;
            background: linear-gradient(135deg, #67e8f9, #818cf8);
        }

        .comment {
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 20px;
            background: rgba(255,255,255,.08);
        }

        .comment-user {
            color: #67e8f9;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .comment-date {
            font-size: 13px;
            color: #cbd5e1;
            margin-top: 10px;
        }

        .message {
            margin-bottom: 15px;
            color: #facc15;
        }

        .navigation-buttons {
            margin-top: 25px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .nav-btn {
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 25px;
            font-weight: 700;
            color: white;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.15);
        }

        .nav-btn:hover {
            background: rgba(103,232,249,.2);
        }

        .login-link {
            color: #67e8f9;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="card">
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>

        <div class="author">
            By <?php echo htmlspecialchars($post['name']); ?> |
            <?php echo $post['created_at']; ?>
        </div>

        <div class="content">
            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
        </div>

        <div class="navigation-buttons">

            <?php if (isset($_SESSION['user_id'])) { ?>
                <a href="user_dashboard.php" class="nav-btn">Dashboard</a>
            <?php } ?>

            <?php if (isset($_SESSION['admin_id'])) { ?>
                <a href="admin_dashboard.php" class="nav-btn">Admin Dashboard</a>
            <?php } ?>

            <a href="index.php" class="nav-btn">Home</a>

        </div>
    </div>

    <div class="card">
        <h2>Add Comment</h2>

        <?php if ($message != "") { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>

        <?php if (isset($_SESSION['user_id'])) { ?>
            <form method="POST">
                <textarea name="comment" placeholder="Write your comment..." required></textarea>
                <button type="submit" name="add_comment">Post Comment</button>
            </form>
        <?php } else { ?>
            <p>Please login as user to add a comment.</p>
            <br>
            <a href="user_login.php" class="login-link">Login Here</a>
        <?php } ?>
    </div>

    <div class="card">
        <h2>Comments</h2>

        <?php if (mysqli_num_rows($comments) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($comments)) { ?>
                <div class="comment">
                    <div class="comment-user">
                        <?php echo htmlspecialchars($row['name']); ?>
                    </div>

                    <div>
                        <?php echo nl2br(htmlspecialchars($row['comment'])); ?>
                    </div>

                    <div class="comment-date">
                        <?php echo $row['created_at']; ?>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No comments yet.</p>
        <?php } ?>

    </div>

</div>

</body>
</html>