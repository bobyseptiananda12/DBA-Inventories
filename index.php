<?php
session_start();

include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: page/login.html");
    exit(); // Terminate script execution after the redirect
} else {
    header("Location: ./page/dashboard.php");
}
