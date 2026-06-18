<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'DBConn.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST["user_id"];
    $brand = $_POST["brand"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    // IMAGE UPLOAD
    $imageName = $_FILES["image"]["name"];
    $tempName = $_FILES["image"]["tmp_name"];
    $folder = "images/" . basename($imageName);

    if (move_uploaded_file($tempName, $folder)) {

       $stmt = $conn->prepare("
INSERT INTO tblClothes
(user_id,name,description,price,image,brand,status)
VALUES (?,?,?,?,?,?,?)
");

       $status = "Pending";

$stmt->bind_param(
"issdsss",
$user_id,
$name,
$description,
$price,
$folder,
$brand,
$status
);

        if ($stmt->execute()) {
            $message = "Your clothing item has been submitted for administrator approval.";
        } else {
            $message = "Database Error: " . $stmt->error;
        }

        $stmt->close();

    } else {
        $message = "Image upload failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Clothes</title>
    <link rel="stylesheet" href="style.css?v=3">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">

    <h2>Upload Clothing Item</h2>

    <?php
    if (!empty($message)) {
        echo "<p><strong>$message</strong></p>";
    }
    ?>

    <form method="POST" enctype="multipart/form-data">

        <label>User ID</label><br>
        <input type="number" name="user_id" required><br><br>

        <label>Brand</label><br>
        <input type="text" name="brand" placeholder="Nike, Adidas, Puma..." required><br><br>

        <label>Item Name</label><br>
        <input type="text" name="name" required><br><br>

        <label>Description</label><br>
        <textarea name="description" rows="5" required></textarea><br><br>

        <label>Price (R)</label><br>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Select Image</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>

        <button type="submit">Upload Item</button>

    </form>

</div>

</body>
</html>