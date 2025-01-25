<?php
session_start();
session_destroy();
header("Location: ../html/guestListLogin.html");
exit();
?>