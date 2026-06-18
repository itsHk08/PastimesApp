<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: login.php");
    exit();
}

include "DBConn.php";

$result = $conn->query("SELECT * FROM tblUser");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css?v=3">
</head>
<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>Manage Users</h2>

<table border="1" width="100%" cellpadding="10">

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Username</th>
<th>Status</th>
<th>Edit</th>
<th>Delete</th>
<th>Verify</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['user_id']; ?></td>

<td><?php echo htmlspecialchars($row['name']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td><?php echo htmlspecialchars($row['username']); ?></td>

<td>

<?php

if($row['isVerified']==1){

echo "Verified";

}else{

echo "Pending";

}

?>

</td>

<td>

<a class="btn" href="editUser.php?id=<?php echo $row['user_id']; ?>">
Edit
</a>

</td>

<td>

<a class="btn" href="deleteUser.php?id=<?php echo $row['user_id']; ?>"
onclick="return confirm('Delete this user?')">

Delete

</a>

</td>

<td>

<?php

if($row['isVerified']==0){

?>

<a class="btn" href="verifyUser.php?id=<?php echo $row['user_id']; ?>">

Verify

</a>

<?php

}else{

echo "✔";

}

?>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>