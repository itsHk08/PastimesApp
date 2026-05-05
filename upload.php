<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'DBConn.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST["user_id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    // IMAGE UPLOAD
    $imageName = $_FILES["image"]["name"];
    $tempName = $_FILES["image"]["tmp_name"];
    $folder = "images/" . $imageName;

    move_uploaded_file($tempName, $folder);

    // INSERT WITH IMAGE
    $stmt = $conn->prepare("INSERT INTO tblClothes (user_id, name, description, price, image) VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param("issds", $user_id, $name, $description, $price, $folder);

    if ($stmt->execute()) {
        $message = "Item uploaded successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Clothes</title>
</head>
<body>

<h2>Upload Clothes</h2>

<form method="POST" enctype="multipart/form-data">

User ID:<br>
<input type="number" name="user_id" required><br><br>

Item Name:<br>
<input type="text" name="name" required><br><br>

Description:<br>
<textarea name="description" required></textarea><br><br>

Price:<br>
<input type="number" step="0.01" name="price" required><br><br>

Image:<br>
<input type="file" name="image" required><br><br>

<button type="submit">Upload</button>

</form>

<p><?php echo $message; ?></p>

</body>
</html>