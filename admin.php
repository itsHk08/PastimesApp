<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'DBConn.php';

// VERIFY USER WHEN BUTTON CLICKED
if (isset($_GET['verify'])) {
    $id = $_GET['verify'];

    $conn->query("UPDATE tblUser SET isVerified = 1 WHERE user_id = $id");
}

// GET ALL USERS
$result = $conn->query("SELECT * FROM tblUser");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<h2>Admin Panel - User Verification</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Username</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['username']; ?></td>

            <td>
                <?php 
                if ($row['isVerified'] == 1) {
                    echo "Verified";
                } else {
                    echo "Not Verified";
                }
                ?>
            </td>

            <td>
                <?php if ($row['isVerified'] == 0) { ?>
                    <a href="admin.php?verify=<?php echo $row['user_id']; ?>">
                        Verify
                    </a>
                <?php } else { ?>
                    ✔
                <?php } ?>
            </td>
        </tr>
    <?php } ?>

</table>

</body>
</html>