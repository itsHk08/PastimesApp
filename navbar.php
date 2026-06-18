<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav>

    <div class="nav-left">

        <a href="index.php" class="logo">
            <img src="images/FITZ.png" alt="F!TZ Logo">
        </a>

    </div>

    <ul>

        <li><a href="index.php">Home</a></li>

        <li><a href="viewClothes.php">Shop</a></li>

        <?php if(isset($_SESSION['user_id'])){ ?>

            <li><a href="upload.php">Sell</a></li>

            <li><a href="cart.php">Cart</a></li>

            <li><a href="messages.php">Messages</a></li>

            <?php if($_SESSION['role']=="admin"){ ?>

                <li><a href="admin.php">Dashboard</a></li>

                <li><a href="verifyUsers.php">Verify Users</a></li>

                <li><a href="users.php">Users</a></li>

                <li><a href="clothes.php">Clothes</a></li>

            <?php } ?>

            <li><a href="logout.php">Logout</a></li>

        <?php } else { ?>

            <li><a href="login.php">Login</a></li>

            <li><a href="register.php">Register</a></li>

        <?php } ?>

    </ul>

</nav>