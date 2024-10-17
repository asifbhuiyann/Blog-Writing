<?php
session_start();
include 'dbconnect.php';

if (isset($_SESSION['user_data'])) {
    $email = $_SESSION['user_data']['email'];
    $heading = $_POST['post_heading'];
    $body = $_POST['post_body'];

    $query = "INSERT INTO blogs (heading, body, timestamp,  email) VALUES (?, ?, NOW(), ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $heading, $body, $email);

    if ($stmt->execute()) {

        header('Location: homepage.php');
    } else {
        echo "Error: " . $stmt->error;
    }
} else {

    header('Location: login.php');
}
?>
