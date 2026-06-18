<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "DBConn.php";

/*
    Only display clothes that have been
    approved by the administrator.
*/



$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

if ($search != "") {

    $stmt = $conn->prepare("
        SELECT tblClothes.*, tblUser.name AS seller
        FROM tblClothes
        JOIN tblUser ON tblClothes.user_id = tblUser.user_id
        WHERE
        tblClothes.name LIKE ?
        OR tblClothes.brand LIKE ?
        OR tblClothes.description LIKE ?
    ");

    $like = "%".$search."%";

    $stmt->bind_param("sss", $like, $like, $like);

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $sql = "
    SELECT tblClothes.*, tblUser.name AS seller
    FROM tblClothes
    JOIN tblUser
    ON tblClothes.user_id = tblUser.user_id
    ";

    $result = $conn->query($sql);

}
?>

<!DOCTYPE html>

<html>

<head>

    <title>F!TZ Shop</title>

    <link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include "navbar.php"; ?>
<div class="container">

<form method="GET" class="search-bar">

<input
type="text"
name="search"
placeholder="Search clothing, brand or description..."
value="<?php echo htmlspecialchars($search); ?>">

<button type="submit">

Search

</button>

</form>

</div>

<div class="container">

<h2>Shop Clothing</h2>

<div class="grid">

<?php

if($result->num_rows>0){

while($row=$result->fetch_assoc()){

?>

<div class="card">

<img
src="<?php echo htmlspecialchars($row['image']); ?>"
alt="Clothing">

<h4>

<?php echo htmlspecialchars($row['brand']); ?>

</h4>

<h3>

<?php echo htmlspecialchars($row['name']); ?>

</h3>

<p>

<?php echo htmlspecialchars($row['description']); ?>

</p>

<p class="price">

R<?php echo number_format($row['price'],2); ?>

</p>

<p>

<strong>Seller:</strong>

<?php echo htmlspecialchars($row['seller']); ?>

</p>

<br>

<a
class="btn"
href="cart.php?add=<?php echo $row['clothes_id']; ?>">

Add to Cart

</a>

</div>

<?php

}

}else{

?>

<div class="card">

<h3>No Products Available</h3>

<p>

There are currently no approved clothing items available.

</p>

</div>

<?php

}

?>

</div>

</div>

</body>

</html>