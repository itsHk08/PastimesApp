<?php
session_start();
include 'DBConn.php';

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ADD ITEM
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $_SESSION['cart'][] = $id;
}

// REMOVE ITEM
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    $_SESSION['cart'] = array_diff($_SESSION['cart'], [$id]);
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Your Cart</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Item</th>
    <th>Price</th>
    <th>Action</th>
</tr>

<?php
$total = 0;

foreach ($_SESSION['cart'] as $item_id) {

    $result = $conn->query("SELECT * FROM tblClothes WHERE clothes_id = $item_id");

    if ($row = $result->fetch_assoc()) {

        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>R" . $row['price'] . "</td>";
        echo "<td><a href='cart.php?remove=" . $row['clothes_id'] . "'>Remove</a></td>";
        echo "</tr>";

        $total += $row['price'];
    }
}
?>

<tr>
    <td><strong>Total</strong></td>
    <td colspan="2"><strong>R<?php echo $total; ?></strong></td>
</tr>

</table>

</body>
</html>