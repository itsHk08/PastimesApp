<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: login.php");
    exit();
}

include "DBConn.php";

// Dashboard statistics
$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM tblUser")->fetch_assoc()['total'];

$totalClothes = $conn->query("SELECT COUNT(*) AS total FROM tblClothes")->fetch_assoc()['total'];

$verifiedUsers = $conn->query("SELECT COUNT(*) AS total FROM tblUser WHERE isVerified=1")->fetch_assoc()['total'];

$pendingUsers = $conn->query("SELECT COUNT(*) AS total FROM tblUser WHERE isVerified=0")->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html>

<head>

<title>Administrator Dashboard</title>

<link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h1>Administrator Dashboard</h1>

<div class="grid">

<div class="card">
<h2>Total Users</h2>
<h1><?php echo $totalUsers; ?></h1>
</div>

<div class="card">
<h2>Total Clothes</h2>
<h1><?php echo $totalClothes; ?></h1>
</div>

<div class="card">
<h2>Verified Users</h2>
<h1><?php echo $verifiedUsers; ?></h1>
</div>

<div class="card">
<h2>Pending Users</h2>
<h1><?php echo $pendingUsers; ?></h1>
</div>

</div>

<br>

<div class="grid">

<div class="card">

<h2>Manage Users</h2>

<p>Edit, verify and remove users.</p>

<a class="btn" href="users.php">

Open

</a>

</div>

<div class="card">

<h2>Verify Users</h2>

<p>Approve newly registered users.</p>

<a class="btn" href="verifyUsers.php">

Open

</a>

</div>

<div class="card">

<h2>Manage Clothes</h2>

<p>Edit and remove clothing items.</p>

<a class="btn" href="clothes.php">

Open

</a>

</div>

</div>

</div>

</body>

</html>