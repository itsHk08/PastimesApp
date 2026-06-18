<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="admin"){

header("Location: login.php");

exit();

}

include "DBConn.php";

$id=$_GET['id'];

$result=$conn->query("SELECT * FROM tblUser WHERE user_id=$id");

$user=$result->fetch_assoc();

if(isset($_POST['update'])){

$name=$_POST['name'];

$email=$_POST['email'];

$username=$_POST['username'];

$conn->query("UPDATE tblUser
SET
name='$name',
email='$email',
username='$username'
WHERE user_id=$id");

header("Location: users.php");

exit();

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Edit User</title>

<link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>Edit User</h2>

<form method="POST">

<label>Name</label>

<input type="text" name="name"
value="<?php echo htmlspecialchars($user['name']); ?>">

<label>Email</label>

<input type="email" name="email"
value="<?php echo htmlspecialchars($user['email']); ?>">

<label>Username</label>

<input type="text" name="username"
value="<?php echo htmlspecialchars($user['username']); ?>">

<br><br>

<button class="btn" name="update">

Save Changes

</button>

</form>

</div>

</body>

</html>