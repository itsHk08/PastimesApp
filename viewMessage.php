<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "DBConn.php";

if (!isset($_GET['id'])) {
    header("Location: messages.php");
    exit();
}

$id = intval($_GET['id']);
$user = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT *
    FROM tblMessages
    WHERE message_id = ?
    AND user_id = ?
");

$stmt->bind_param("ii", $id, $user);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Message not found.");
}

$message = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>

    <title>View Message | F!TZ</title>

    <link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<div class="card">

<h2>

<?php echo htmlspecialchars($message['subject']); ?>

</h2>

<p>

<strong>From:</strong>

<?php echo htmlspecialchars($message['sender_role']); ?>

</p>

<p>

<strong>Date:</strong>

<?php echo $message['sent_at']; ?>

</p>

<hr>

<p style="margin-top:20px; line-height:1.8;">

<?php echo nl2br(htmlspecialchars($message['message'])); ?>

</p>

<br>

<a class="btn" href="messages.php">

← Back to Inbox

</a>

</div>

</div>

</body>

</html>