<?php
session_start();
session_destroy();
header("Location: ../guestListLogin.html");
exit();
?>