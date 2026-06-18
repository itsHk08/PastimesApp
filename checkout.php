<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "DBConn.php";

$user_id = $_SESSION['user_id'];

// Calculate total
$sql = "SELECT SUM(tblCart.quantity * tblClothes.price) AS total
        FROM tblCart
        JOIN tblClothes
        ON tblCart.clothes_id = tblClothes.clothes_id
        WHERE tblCart.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$total = $row['total'];

if ($total == NULL) {
    $total = 0;
}

if(isset($_POST['checkout'])){

    // Save order
    $stmt = $conn->prepare("
        INSERT INTO tblOrders(user_id,total)
        VALUES(?,?)
    ");

    $stmt->bind_param("id",$user_id,$total);
    $stmt->execute();

    // Empty cart
    $stmt = $conn->prepare("
        DELETE FROM tblCart
        WHERE user_id=?
    ");

    $stmt->bind_param("i",$user_id);
    $stmt->execute();

    $success = true;

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Checkout</title>

<link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>Checkout</h2>

<?php if(isset($success)){ ?>

<div class="card">

<h2>✅ Order Successful!</h2>

<p>

Thank you for shopping with Pastimes.

</p>

<p>

Your order has been placed successfully.

</p>

<a class="btn" href="viewClothes.php">

Continue Shopping

</a>

</div>

<?php } else { ?>

<div class="card">

<h3>Order Summary</h3>

<p>

Total Amount

</p>

<h2>

R<?php echo number_format($total,2); ?>

</h2>

<form method="POST">

<button name="checkout">

Confirm Order

</button>

</form>

</div>

<?php } ?>

</div>

</body>

</html>