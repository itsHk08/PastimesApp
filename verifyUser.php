<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="admin"){

header("Location: login.php");

exit();

}

include "DBConn.php";

$id=$_GET['id'];

$conn->query("UPDATE tblUser SET isVerified=1 WHERE user_id=$id");

header("Location: users.php");

exit();

?>