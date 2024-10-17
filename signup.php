<?php
include 'dbconnect.php';

if (isset($_POST['save'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["pw"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, pw) VALUES (?, ?, ?)");

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Sign Up Successful');</script>";

        setcookie("user", $email, 0, "/");

        session_start();

        header("Location: login.html");
        exit();
    } else {
        die("Error executing query: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>