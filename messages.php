<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "DBConn.php";

$user = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT *
    FROM tblMessages
    WHERE user_id = ?
    ORDER BY sent_at DESC
");

$stmt->bind_param("i", $user);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>

    <title>My Messages | F!TZ</title>

    <link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>My Messages</h2>

<?php if($result->num_rows > 0){ ?>

<table>

<tr>

<th>From</th>

<th>Subject</th>

<th>Date</th>

<th>Open</th>

</tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>

<td>

<?php echo htmlspecialchars($row['sender_role']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['subject']); ?>

</td>

<td>

<?php echo $row['sent_at']; ?>

</td>

<td>

<a class="btn"
href="viewMessage.php?id=<?php echo $row['message_id']; ?>">

Open

</a>

</td>

</tr>

<?php } ?>

</table>

<?php } else { ?>

<p style="text-align:center; margin-top:30px;">

You have no messages.

</p>

<?php } ?>

</div>

</body>

</html>