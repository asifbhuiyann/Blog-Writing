<?php
session_start();
include 'dbconnect.php';

if (isset($_SESSION['user_data']) && isset($_GET['id'])) {
    $email = $_SESSION['user_data']['email'];
    $postId = intval($_GET['id']);

    $query = "DELETE FROM blogs WHERE id = ? AND email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $postId, $email);

    if ($stmt->execute()) {
        header("Location: homepage.php"); 
        exit();
    } else {
        echo "Error deleting post: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>