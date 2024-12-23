<!DOCTYPE html>
<html>
    <head>
        <title>Error Page</title>
        <link rel="stylesheet" href="css/style.css">
        <script src="js/app.js"></script>
    </head>

<body>
    <nav>
        <ul>
            <li><a href="homepage.html">Homepage</a></li>
            <li><a href="tableReservation.html">Table Reservation</a></li>
            <li><a href="guestListLogin.html">Guest List Login</a></li>
        </ul>
    </nav>

    <h1>Error</h1>

    <p><?php echo isset($_GET['error_message']) ? htmlspecialchars($_GET['error_message']) : "An error occurred."; ?></p>

    <footer>
        <div class="leftDiv">
            <p><b>Phone Number:</b>
            <br> 0123456789</p>
        </div>

        <div class="rightDiv">
            <p><b>Email Address:</b>
            <br>ZeynepsRestaurant@gmail.com</p>
        </div>
    </footer>
</body>
</html>