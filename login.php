<?php
include 'DBConn.php';

$username = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (!empty($username) && !empty($password)) {

        $sql = "SELECT * FROM tblUser WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            // Verify hashed password
            if (password_verify($password, $row['password'])) {

                // Check if verified
                if ($row['isVerified'] == 1) {
                    $message = "User " . $row['name'] . " is logged in";
                } else {
                    $message = "Account not verified. Please wait for admin approval.";
                }

            } else {
                $message = "Incorrect password.";
            }

        } else {
            $message = "User not found. Please register.";
        }

    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<h2>Login</h2>

<form method="POST">

    Username:<br>
    <input type="text" name="username" required 
           value="<?php echo htmlspecialchars($username); ?>"><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>

</form>

<p><?php echo $message; ?></p>

</body>
</html>