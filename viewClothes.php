<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'DBConn.php';

// Fetch clothes + seller
$sql = "SELECT tblClothes.*, tblUser.name AS seller 
        FROM tblClothes 
        JOIN tblUser ON tblClothes.user_id = tblUser.user_id";

$result = $conn->query($sql);

if (!$result) {
    die("Query error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shop - Pastimes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<h2>Available Clothes</h2>

<div class="container">
<div class="grid">

<?php
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        echo "<div class='card'>";

        // Image
        echo "<img src='" . $row['image'] . "' alt='Clothing Image'>";

        // Name
        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";

        // Description
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";

        // Price
        echo "<p class='price'>R" . htmlspecialchars($row['price']) . "</p>";

        // Seller
        echo "<p><small>Seller: " . htmlspecialchars($row['seller']) . "</small></p>";

        // Add to Cart
        echo "<a class='btn' href='cart.php?add=" . $row['clothes_id'] . "'>
                Add to Cart
              </a>";

        echo "</div>";
    }

} else {
    echo "<p style='text-align:center;'>No clothes available</p>";
}
?>

</div>
</div>

</body>
</html>