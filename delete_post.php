<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    mysqli_query($conn,
    "DELETE FROM posts
     WHERE id='$id'
     AND user_id='$user_id'");
}

header("Location: user_dashboard.php");
exit();
?>