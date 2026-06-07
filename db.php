<?php
$conn = mysqli_connect("localhost", "root", "", "blog_platform");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>