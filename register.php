<?php
include 'DBConn.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO tblUser (name,email,username,password)
            VALUES ('$name','$email','$username','$password')";

    if ($conn->query($sql)) {
        $message = "Registration successful!";
    } else {
        $message = "Error occurred.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register up big dawg</title>
    <link rel="stylesheet" href="style.css?v=3">
</head>
<body>
</html>

<form method="POST">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>

    <button type="submit">Register</button>
</form>

<p><?php echo $message; ?></p>