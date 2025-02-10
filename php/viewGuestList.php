<?php
include 'DBconnection.php';
session_start();

if (isset($_SESSION['timeout']) && (time() - $_SESSION['timeout']) > $_SESSION['timeoutDuration']){
    session_unset();
    session_destroy();
    header("Location: ../html/errorPages/sessionExpired.html");
    exit();
}

$_SESSION['timeout'] = time();

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true){
    try{
        $sql = "SELECT reservationID, emailAddress, firstName, lastName, numberOfPeople, timeSlot, arrived
                FROM reservations
                WHERE dateOfReservation = CURDATE()
                ORDER BY arrived ASC, timeSlot ASC";
        $stmt = $conn->query($sql);
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Guest List</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="../js/sessionTimeout.js"></script>
        <script>
            setupSessionTimeout(<?php echo $_SESSION['timeoutDuration'] * 1000; ?>);
        </script>
    </head>
    
    <body>
        <nav>
            <ul>
                <li><a href="../html/homepage.html">Homepage</a></li>
                <li><a href="tableReservation.php">Table Reservation</a></li>
                <li><a href="../html/guestListLogin.html">Guest List Login</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <h1>Guest List for Today</h1>
        <form action="updateArrivals.php" method="POST">
            <table>
                <tr>
                    <th>Reservation ID</th>
                    <th>Name</th>
                    <th>Number of People</th>
                    <th>Reservation Time</th>
                    <th>Mark as Arrived</th>
                </tr>
                <?php if(!empty($reservations)){ ?>
                    <?php foreach($reservations as $reservation){ ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['reservationID']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['firstName'] . ' ' . $reservation['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['numberOfPeople']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['timeSlot']); ?></td>
                            <td>
                                <input type="checkbox"
                                name="arrived[]"
                                value="<?php echo $reservation['emailAddress']; ?>"
                                <?php echo $reservation['arrived'] ? 'checked disabled' : '';?>>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4">No reservations today.</td>
                    </tr>
                <?php } ?>
            </table>
            <br>
            <button type="submit">Update Arrivals</button>
            <br><br>
        </form>

        <footer>
            <div class="leftDiv">
                <p><b>Phone Number:</b><br>0123456789</p>
            </div>
            <div class="rightDiv">
                <p><b>Email Address:</b><br>ZeynepsRestaurant@gmail.com</p>
            </div>
        </footer>
</body>
</html>
        <?php
        }
        catch(PDOException $e){
            header("Location: errorPages/error.php?error_message=A database error occurred.");
            exit();
        }}
    else{
        header("Location: ../html/guestListLogin.html");
        exit();
    }
?>