<?php
session_start();
include(__DIR__ . '/../config/config.php');

if(!isset($_SESSION['auth']))
{
    $_SESSION['status'] = "Login to access dashboard";
    $_SESSION['status_code'] = "warning";
    header("Location: ../index.php");
    exit(0);
}
else
{
    if ($_SESSION['userRole'] != "seller")
    {
        $_SESSION['status'] = "You are not authorized as a Vendor!";
        $_SESSION['status_code'] = "warning";
        header("Location: ../index.php");
        exit(0);
    }
}

?>

