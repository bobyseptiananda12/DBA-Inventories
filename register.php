<?php
session_start();

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security

    // Insert user data into the database
    $query = "INSERT INTO users (username,name, password, usertype) VALUES ('$username', '$name','$hashed_password', 'user')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Registration Successful');</script>";
        header('index.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
