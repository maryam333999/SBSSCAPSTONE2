<?php
session_start();


unset($_SESSION['selected_supervisors']);
unset($_SESSION['selected_buses']);


header("Location: currentroutes.php");
exit();
?>
