<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    mysqli_query($conn,
    "DELETE FROM comments
     WHERE id='$id'");
}

header("Location: manage_comments.php");
exit();
?>