<?php
include 'dbconnect.php';
session_start();

if (isset($_SESSION['email'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login.html");
    exit();
} else {
    header("Location: login.html");
    exit();
}
?>