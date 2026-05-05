<?php
include 'DBConn.php';

// Drop table
$conn->query("DROP TABLE IF EXISTS tblUser");

// Create table
$conn->query("CREATE TABLE tblUser (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    username VARCHAR(50),
    password VARCHAR(255),
    isVerified TINYINT DEFAULT 0
)");

// Read file
$file = fopen("userData.txt", "r");

while (($line = fgets($file)) !== false) {
    $data = explode(",", trim($line));

    $name = $data[0];
    $email = $data[1];
    $username = $data[2];
    $password = password_hash($data[3], PASSWORD_DEFAULT);

    $conn->query("INSERT INTO tblUser (name, email, username, password)
                  VALUES ('$name','$email','$username','$password')");
}

fclose($file);

echo "Table created and data loaded!";
?>