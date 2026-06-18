<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "DBConn.php";

$user_id = $_SESSION['user_id'];

/* ---------------- ADD ITEM ---------------- */

if (isset($_GET['add'])) {

    $clothes_id = intval($_GET['add']);

    $check = $conn->prepare("SELECT * FROM tblCart WHERE user_id=? AND clothes_id=?");
    $check->bind_param("ii", $user_id, $clothes_id);
    $check->execute();

    $result = $check->get_result();

    if ($result->num_rows > 0) {

        $conn->query("
            UPDATE tblCart
            SET quantity = quantity + 1
            WHERE user_id=$user_id
            AND clothes_id=$clothes_id
        ");

    } else {

        $stmt = $conn->prepare("
            INSERT INTO tblCart(user_id, clothes_id, quantity)
            VALUES(?,?,1)
        ");

        $stmt->bind_param("ii", $user_id, $clothes_id);
        $stmt->execute();

    }

    header("Location: cart.php");
    exit();
}

/* ---------------- REMOVE ---------------- */

if(isset($_GET['remove'])){

$id=intval($_GET['remove']);

$conn->query("
DELETE FROM tblCart
WHERE cart_id=$id
AND user_id=$user_id
");

header("Location: cart.php");
exit();

}

/* ---------------- CHANGE QUANTITY ---------------- */

if(isset($_GET['plus'])){

$id=intval($_GET['plus']);

$conn->query("
UPDATE tblCart
SET quantity=quantity+1
WHERE cart_id=$id
");

header("Location: cart.php");
exit();

}

if(isset($_GET['minus'])){

$id=intval($_GET['minus']);

$conn->query("
UPDATE tblCart
SET quantity=quantity-1
WHERE cart_id=$id
AND quantity>1
");

header("Location: cart.php");
exit();

}

/* ---------------- LOAD CART ---------------- */

$sql="SELECT
tblCart.*,
tblClothes.name,
tblClothes.brand,
tblClothes.price,
tblClothes.image
FROM tblCart

JOIN tblClothes
ON tblCart.clothes_id=tblClothes.clothes_id

WHERE tblCart.user_id=$user_id";

$result=$conn->query($sql);

$total=0;
?>

<!DOCTYPE html>

<html>

<head>

<title>Shopping Cart</title>

<link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>Your Shopping Cart</h2>

<table border="1" width="100%" cellpadding="10">

<tr>

<th>Image</th>
<th>Brand</th>
<th>Item</th>
<th>Price</th>
<th>Quantity</th>
<th>Subtotal</th>
<th>Remove</th>

</tr>

<?php

while($row=$result->fetch_assoc()){

$subtotal=$row['price']*$row['quantity'];

$total+=$subtotal;

?>

<tr>

<td>

<img src="<?php echo $row['image']; ?>" width="80">

</td>

<td><?php echo htmlspecialchars($row['brand']); ?></td>

<td><?php echo htmlspecialchars($row['name']); ?></td>

<td>R<?php echo number_format($row['price'],2); ?></td>

<td>

<a href="cart.php?minus=<?php echo $row['cart_id']; ?>">➖</a>

<?php echo $row['quantity']; ?>

<a href="cart.php?plus=<?php echo $row['cart_id']; ?>">➕</a>

</td>

<td>

R<?php echo number_format($subtotal,2); ?>

</td>

<td>

<a class="btn"

href="cart.php?remove=<?php echo $row['cart_id']; ?>">

Remove

</a>

</td>

</tr>

<?php } ?>

<tr>

<td colspan="5">

<strong>Total</strong>

</td>

<td colspan="2">

<strong>

R<?php echo number_format($total,2); ?>

</strong>

</td>

</tr>

</table>

<br>

<a class="btn" href="viewClothes.php">

Continue Shopping

</a>

<a class="btn" href="checkout.php">

Checkout

</a>

</div>

</body>

</html>