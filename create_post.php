<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$message = "";

if (isset($_POST['publish'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $user_id = $_SESSION['user_id'];

    if (!empty($title) && !empty($content)) {

        $query = "INSERT INTO posts(user_id,title,content)
                  VALUES('$user_id','$title','$content')";

        if (mysqli_query($conn, $query)) {
            $message = "Blog published successfully!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }

    } else {
        $message = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Blog | BlogSphere</title>

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

        .back-btn{
            text-decoration:none;
            color:white;

            padding:12px 20px;
            border-radius:25px;

            background:rgba(255,255,255,.1);
        }

        .container{
            width:80%;
            max-width:900px;
            margin:40px auto;
        }

        .create-box{
            padding:40px;
            border-radius:30px;

            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.15);

            backdrop-filter:blur(20px);
        }

        .create-box h1{
            margin-bottom:10px;
        }

        .create-box p{
            color:#dbe4f0;
            margin-bottom:25px;
        }

        .message{
            padding:15px;
            margin-bottom:20px;

            border-radius:15px;

            background:rgba(34,197,94,.15);
            color:#86efac;
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

        input::placeholder,
        textarea::placeholder{
            color:#cbd5e1;
        }

        textarea{
            min-height:300px;
            resize:vertical;
        }

        button{
            padding:14px 30px;

            border:none;
            cursor:pointer;

            border-radius:30px;

            color:#020617;
            font-size:16px;
            font-weight:800;

            background:
            linear-gradient(
            135deg,
            #67e8f9,
            #818cf8);
        }

        button:hover{
            opacity:.95;
        }
    </style>

</head>
<body>

<div class="navbar">

    <div class="logo">
        Blog<span>Sphere</span>
    </div>

    <a href="user_dashboard.php"
       class="back-btn">
       Dashboard
    </a>

</div>

<div class="container">

    <div class="create-box">

        <h1>Create New Blog</h1>

        <p>
            Write and publish your blog post.
        </p>

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
                placeholder="Enter Blog Title"
                required>

            <textarea
                name="content"
                placeholder="Write your blog content here..."
                required></textarea>

            <button
                type="submit"
                name="publish">
                Publish Blog
            </button>

        </form>

    </div>

</div>

</body>
</html>