<?php
ob_start();
session_start();

if (!isset($_SESSION['sign_type'])){
    header('location: login.php');
    exit();
} else {
    header('location: ' . $_SESSION['location']);
    exit();
}
