<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: login.php");
    exit();
}

include "DBConn.php";

$users = $conn->query("SELECT user_id, name FROM tblUser ORDER BY name");

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $receiver = intval($_POST["receiver"]);
    $subject = trim($_POST["subject"]);
    $body = trim($_POST["message"]);

    $stmt = $conn->prepare("
        INSERT INTO tblMessages
        (sender_role, user_id, subject, message)
        VALUES (?, ?, ?, ?)
    ");

    $sender = "Administrator";

    $stmt->bind_param("siss", $sender, $receiver, $subject, $body);

    if ($stmt->execute()) {
        $success = "Message sent successfully.";
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Send Message | F!TZ</title>

    <link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h2>Send Message</h2>

<?php
if ($success != "") {
    echo "<p style='color:green;font-weight:bold;'>$success</p>";
}

if ($error != "") {
    echo "<p style='color:red;font-weight:bold;'>$error</p>";
}
?>

<form method="POST">

<label>Select User</label>

<select name="receiver" required>

<option value="">-- Select User --</option>

<?php
while ($user = $users->fetch_assoc()) {
?>

<option value="<?php echo $user['user_id']; ?>">

<?php echo htmlspecialchars($user['name']); ?>

</option>

<?php
}
?>

</select>

<label>Subject</label>

<input
type="text"
name="subject"
required>

<label>Message</label>

<textarea
name="message"
rows="6"
required></textarea>

<button
type="submit"
name="send"
class="btn">

Send Message

</button>

</form>

</div>

</body>

</html>