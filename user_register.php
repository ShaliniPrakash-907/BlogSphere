<?php
include 'db.php';

$message = "";

if(isset($_POST['register']))
{
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0)
    {
        $message = "Email already exists!";
    }
    else
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users(name,email,password,role)
                  VALUES('$name','$email','$hashedPassword','user')";

        if(mysqli_query($conn,$query))
        {
            header("Location: user_login.php");
            exit();
        }
        else
        {
            $message = "Registration Failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration | BlogSphere</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI',sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            color:white;

            background:
            radial-gradient(circle at top left,
            rgba(99,102,241,.7), transparent 32%),

            radial-gradient(circle at top right,
            rgba(236,72,153,.55), transparent 30%),

            linear-gradient(135deg,
            #020617,#111827,#1e1b4b);
        }

        .container{
            width:900px;
            display:grid;
            grid-template-columns:1fr 420px;
            gap:40px;
            align-items:center;
        }

        .left-section h1{
            font-size:55px;
            margin-bottom:20px;
            line-height:1.1;
        }

        .left-section p{
            color:#dbe4f0;
            font-size:18px;
            line-height:1.8;
        }

        .features{
            margin-top:25px;
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        }

        .features span{
            padding:10px 16px;
            border-radius:25px;
            background:rgba(103,232,249,.12);
            color:#67e8f9;
            font-size:14px;
            font-weight:700;
        }

        .register-box{
            padding:40px;
            border-radius:30px;

            background:rgba(255,255,255,.08);
            border:1px solid rgba(255,255,255,.15);

            backdrop-filter:blur(20px);
            box-shadow:0 25px 60px rgba(0,0,0,.35);
        }

        .register-box h2{
            text-align:center;
            margin-bottom:10px;
            font-size:30px;
        }

        .register-box p{
            text-align:center;
            color:#dbe4f0;
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:14px;
            margin-bottom:15px;

            border:none;
            outline:none;

            border-radius:14px;

            color:white;
            background:rgba(255,255,255,.10);
        }

        input::placeholder{
            color:#cbd5e1;
        }

        button{
            width:100%;
            padding:14px;

            border:none;
            border-radius:30px;

            cursor:pointer;

            font-size:16px;
            font-weight:800;

            color:#020617;

            background:linear-gradient(
            135deg,
            #67e8f9,
            #818cf8);
        }

        button:hover{
            opacity:.95;
        }

        .message{
            padding:12px;
            margin-bottom:15px;

            border-radius:12px;

            background:rgba(239,68,68,.18);
            color:#fecaca;
            text-align:center;
        }

        .login-link{
            text-align:center;
            margin-top:18px;
        }

        .login-link a{
            color:#67e8f9;
            text-decoration:none;
            font-weight:700;
        }

        .home-link{
            display:block;
            text-align:center;
            margin-top:12px;

            color:#67e8f9;
            text-decoration:none;
            font-weight:700;
        }

        @media(max-width:900px)
        {
            .container{
                grid-template-columns:1fr;
                width:90%;
            }

            .left-section{
                text-align:center;
            }

            .left-section h1{
                font-size:38px;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="left-section">
        <h1>Create Your BlogSphere Account</h1>

        <p>
            Join BlogSphere to create blogs,
            share ideas, comment on posts,
            and interact with other users.
        </p>

        <div class="features">
            <span>Blog Posts</span>
            <span>Comments</span>
            <span>User Dashboard</span>
            <span>Content Sharing</span>
        </div>
    </div>

    <div class="register-box">

        <h2>User Registration</h2>
        <p>Create your account</p>

        <?php
        if($message!="")
        {
            echo "<div class='message'>$message</div>";
        }
        ?>

        <form method="POST">

            <input type="text"
                   name="name"
                   placeholder="Enter Name"
                   required>

            <input type="email"
                   name="email"
                   placeholder="Enter Email"
                   required>

            <input type="password"
                   name="password"
                   placeholder="Enter Password"
                   required>

            <button type="submit"
                    name="register">
                    Register
            </button>

        </form>

        <div class="login-link">
            Already have an account?
            <a href="user_login.php">Login</a>
        </div>

        <a href="index.php" class="home-link">
            Back to Home
        </a>

    </div>

</div>

</body>
</html>