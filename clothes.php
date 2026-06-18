<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: login.php");
    exit();
}

include "DBConn.php";

$sql = "SELECT
            tblClothes.*,
            tblUser.name AS seller
        FROM tblClothes
        JOIN tblUser
        ON tblClothes.user_id = tblUser.user_id
        ORDER BY tblClothes.clothes_id DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Query Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Clothing | F!TZ</title>

    <link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>Manage Clothing</h2>

<table>

<tr>

<th>Image</th>
<th>Brand</th>
<th>Item</th>
<th>Seller</th>
<th>Price</th>
<th>Status</th>
<th>Approve</th>
<th>Edit</th>
<th>Delete</th>

</tr>

<?php

while($row = $result->fetch_assoc()){

?>

<tr>

<td>

<img
src="<?php echo htmlspecialchars($row['image']); ?>"
width="80"
height="80"
style="object-fit:cover;border-radius:8px;">

</td>

<td>

<?php echo htmlspecialchars($row['brand']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['name']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['seller']); ?>

</td>

<td>

R<?php echo number_format($row['price'],2); ?>

</td>

<td>

<?php

if($row['status']=="Approved"){

    echo "<span style='color:green;font-weight:bold;'>Approved</span>";

}else{

    echo "<span style='color:orange;font-weight:bold;'>Pending</span>";

}

?>

</td>

<td>

<?php

if($row['status']=="Pending"){

?>

<a
class="btn"
href="approveClothes.php?id=<?php echo $row['clothes_id']; ?>">

Approve

</a>

<?php

}else{

echo "✔";

}

?>

</td>

<td>

<a
class="btn"
href="editClothes.php?id=<?php echo $row['clothes_id']; ?>">

Edit

</a>

</td>

<td>

<a
class="btn"
href="deleteClothes.php?id=<?php echo $row['clothes_id']; ?>"
onclick="return confirm('Delete this clothing item?')">

Delete

</a>

</td>

</tr>

<?php

}

?>

</table>

</div>

</body>

</html>