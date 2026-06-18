<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="admin"){

header("Location: login.php");

exit();

}

include "DBConn.php";

$id=$_GET['id'];

$conn->query("DELETE FROM tblClothes WHERE clothes_id=$id");

header("Location: clothes.php");

exit();

?>