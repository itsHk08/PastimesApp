<?php
session_start();



include 'DBConn.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (!empty($username) && !empty($password)) {

        $stmt = $conn->prepare("SELECT * FROM tblUser WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {

                if ($row['isVerified'] == 0) {

                    $message = "Your account has not been verified by the administrator yet.";

                } else {

                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['role'] = $row['role'];

                    if ($row['role'] == "admin") {
    die("Role is admin");
} else {
    die("Role is customer");
}
                }

            } else {

                $message = "Incorrect password.";

            }

        } else {

            $message = "User not found.";

        }

    } else {

        $message = "Please complete all fields.";

    }

}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Login - Pastimes</title>

    <link rel="stylesheet" href="style.css?v=3">

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container">

<h2>Login</h2>

<form method="POST">

<label>Username</label>

<input type="text" name="username" required>

<label>Password</label>

<input type="password" name="password" required>

<button type="submit">Login</button>

</form>

<?php

if($message!=""){

    echo "<p style='text-align:center;color:red;font-weight:bold;'>$message</p>";

}

?>

</div>

</body>

</html>