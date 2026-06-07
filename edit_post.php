<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: user_dashboard.php");
    exit();
}

$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$post = mysqli_query($conn,
"SELECT * FROM posts
 WHERE id='$post_id'
 AND user_id='$user_id'");

if (mysqli_num_rows($post) == 0) {
    header("Location: user_dashboard.php");
    exit();
}

$postData = mysqli_fetch_assoc($post);

$message = "";

if(isset($_POST['update']))
{
    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $content = mysqli_real_escape_string($conn,$_POST['content']);

    $update = "UPDATE posts
               SET title='$title',
                   content='$content'
               WHERE id='$post_id'
               AND user_id='$user_id'";

    if(mysqli_query($conn,$update))
    {
        $message = "Blog updated successfully!";

        $post = mysqli_query($conn,
        "SELECT * FROM posts
         WHERE id='$post_id'
         AND user_id='$user_id'");

        $postData = mysqli_fetch_assoc($post);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Blog</title>

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

        .container{
            width:80%;
            max-width:900px;
            margin:40px auto;
        }

        .box{
            padding:40px;
            border-radius:30px;

            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.15);

            backdrop-filter:blur(20px);
        }

        h1{
            margin-bottom:20px;
        }

        input,
        textarea{
            width:100%;
            padding:15px;
            margin-bottom:20px;

            border:none;
            outline:none;

            border-radius:15px;

            color:white;
            background:rgba(255,255,255,.1);
        }

        textarea{
            min-height:300px;
        }

        button{
            padding:14px 30px;
            border:none;
            cursor:pointer;
            border-radius:30px;

            font-weight:800;

            color:#020617;

            background:
            linear-gradient(
            135deg,
            #67e8f9,
            #818cf8);
        }

        .message{
            padding:15px;
            margin-bottom:20px;

            border-radius:15px;

            background:rgba(34,197,94,.15);
            color:#86efac;
        }

        .back{
            display:inline-block;
            margin-top:20px;
            color:#67e8f9;
            text-decoration:none;
        }
    </style>

</head>
<body>

<div class="container">

    <div class="box">

        <h1>Edit Blog</h1>

        <?php
        if($message!="")
        {
            echo "<div class='message'>$message</div>";
        }
        ?>

        <form method="POST">

            <input
            type="text"
            name="title"
            value="<?php echo htmlspecialchars($postData['title']); ?>"
            required>

            <textarea
            name="content"
            required><?php echo htmlspecialchars($postData['content']); ?></textarea>

            <button
            type="submit"
            name="update">
            Update Blog
            </button>

        </form>

        <a href="user_dashboard.php" class="back">
            ← Back to Dashboard
        </a>

    </div>

</div>

</body>
</html>