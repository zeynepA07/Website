<?php
session_start();
session_destroy();


//redirect user to the guestListLogin page after logout.
header("Location: ../html/guestListLogin.html");
exit();
?>