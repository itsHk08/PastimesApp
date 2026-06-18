<?php
session_start();

include "DBConn.php";

// Featured products (latest 4)
$result = $conn->query("SELECT * FROM tblClothes ORDER BY clothes_id DESC LIMIT 4");
?>

<!DOCTYPE html>
<html>

<head>

    <title>F!TZ | Find Your Fit</title>

    <link rel="stylesheet" href="style.css?v=2">

</head>

<body>

<?php include "navbar.php"; ?>

<!-- HERO -->

<section class="hero">

    <div class="hero-content">

        <h1>Find Your Fit.</h1>

        <p>
            Discover premium second-hand fashion from verified sellers.
        </p>

        <br>

        <a href="viewClothes.php" class="btn">
            Shop Now
        </a>

    </div>

</section>

<!-- FEATURED PRODUCTS -->

<div class="container">

<h2>Featured Products</h2>

<div class="grid">

<?php

while($row = $result->fetch_assoc()){

?>

<div class="card">

<img src="<?php echo $row['image']; ?>">

<h4><?php echo htmlspecialchars($row['brand']); ?></h4>

<h3><?php echo htmlspecialchars($row['name']); ?></h3>

<p>

R<?php echo number_format($row['price'],2); ?>

</p>

<a class="btn"

href="cart.php?add=<?php echo $row['clothes_id']; ?>">

Add to Cart

</a>

</div>

<?php

}

?>

</div>

</div>

<!-- WHY CHOOSE -->

<section class="why">

<div class="container">

<h2>Why Choose F!TZ?</h2>

<div class="grid">

<div class="card">

<h3>Verified Sellers</h3>

<p>

Every seller is verified by our administrators before selling.

</p>

</div>

<div class="card">

<h3>Affordable Fashion</h3>

<p>

Find quality second-hand clothing at amazing prices.

</p>

</div>

<div class="card">

<h3>Secure Shopping</h3>

<p>

Simple checkout and protected customer accounts.

</p>

</div>

</div>

</div>

</section>

<footer>

<h3>F!TZ</h3>

<p>

Find Your Fit. Own Your Style.

</p>

<br>

<p>

© 2026 F!TZ. All Rights Reserved.

</p>

</footer>

</body>

</html>