<?php
session_start(); 
include 'dbconnect.php';

if (isset($_POST['login'])) {
    $email = $_POST["email"];
    $password = $_POST["pw"];

    // Modify the query to fetch the user's name as well
    $stmt = $conn->prepare("SELECT pw, name FROM users WHERE email = ?");

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $name); 
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {

            $_SESSION['user_data'] = [
                'email' => $email,
                'name' => $name, 
            ];

            echo "<script>
                    alert('Login Successful');
                    window.location.href = 'homepage.php';
                    </script>";
            exit();
        } else {
            echo "<script>alert('Invalid Password');</script>";
        }
    } else {
        echo "<script>alert('No user found with that email');</script>";
    }

    $stmt->close();
    $conn->close();
}
