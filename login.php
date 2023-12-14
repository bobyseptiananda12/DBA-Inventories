<?php
session_start();

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, user is authenticated
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $row['usertype']; // Assuming 'user_type' is the column in your database
            $_SESSION['name'] = $row['name'];
            $_SESSION['createdAt'] = $row['createdAt'];
            $_SESSION['lastUpdatedAt'] = $row['lastUpdatedAt'];
            header("location: index.php"); // Redirect to a welcome page upon successful login
            // echo $_SESSION['usertype'];
        } else {
            // Incorrect password
            echo "<script>alert('Invalid username or password');</script>";
            header("location: page/login.html");
        }
    } else {
        // User not found
        echo "<script>alert('Invalid username or password');</script>";
    }
}

mysqli_close($conn);
