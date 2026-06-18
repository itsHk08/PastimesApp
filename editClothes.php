<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: login.php");
    exit();
}

include "DBConn.php";

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM tblClothes WHERE clothes_id=$id");

$item = $result->fetch_assoc();

if(isset($_POST['update'])){

$brand=$_POST['brand'];
$name=$_POST['name'];
$description=$_POST['description'];
$price=$_POST['price'];

$conn->query("UPDATE tblClothes
SET
brand='$brand',
name='$name',
description='$description',
price='$price'
WHERE clothes_id=$id");

header("Location: clothes.php");

exit();

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Clothing</title>

<link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>Edit Clothing</h2>

<form method="POST">

<label>Brand</label>

<input type="text"
name="brand"
value="<?php echo htmlspecialchars($item['brand']); ?>">

<label>Item Name</label>

<input type="text"
name="name"
value="<?php echo htmlspecialchars($item['name']); ?>">

<label>Description</label>

<textarea name="description"><?php echo htmlspecialchars($item['description']); ?></textarea>

<label>Price</label>

<input type="number"
step="0.01"
name="price"
value="<?php echo $item['price']; ?>">

<br><br>

<button class="btn" name="update">

Save Changes

</button>

</form>

</div>

</body>

</html>