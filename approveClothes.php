<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="admin"){

header("Location:login.php");
exit();

}

include "DBConn.php";

$id = intval($_GET['id']);

$conn->query("
UPDATE tblClothes
SET status='Approved'
WHERE clothes_id=$id
");

header("Location:clothes.php");
exit();
?>