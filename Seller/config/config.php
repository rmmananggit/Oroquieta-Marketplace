<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "marketplace";

$con = mysqli_connect("$host", "$username", "$password", "$database");

if(!$con)
{
    // header("Location: .../error/error.php");
    die();
}

?>

