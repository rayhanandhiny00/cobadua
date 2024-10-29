<?php

session_start();

include("security/bataslogin.php");

//kosongkan session user login
$_SESSION = [];

session_unset();
session_destroy();
header('location: login.php');

?>