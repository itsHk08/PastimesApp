<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: login.php");
    exit();
}

include "DBConn.php";

$result = $conn->query("
SELECT *
FROM tblUser
WHERE isVerified = 0
ORDER BY user_id DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Verify Users | F!TZ</title>

<link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>Pending User Verification</h2>

<?php
if($result->num_rows > 0){
?>

<table>

<tr>

<th>Name</th>
<th>Email</th>
<th>Username</th>
<th>Role</th>
<th>Action</th>

</tr>

<?php
while($row = $result->fetch_assoc()){
?>

<tr>

<td><?php echo htmlspecialchars($row['name']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td><?php echo htmlspecialchars($row['username']); ?></td>

<td><?php echo htmlspecialchars($row['role']); ?></td>

<td>

<a
class="btn"
href="verifyUser.php?id=<?php echo $row['user_id']; ?>">

Verify

</a>

</td>

</tr>

<?php
}
?>

</table>

<?php
}else{
?>

<p style="text-align:center;">

No users are waiting for verification.

</p>

<?php
}
?>

</div>

</body>

</html>