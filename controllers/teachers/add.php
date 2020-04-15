<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $name = $_POST['name'];
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $error = [];

    foreach ($_POST as $key => $item) {
        if (empty($item)){
            $key = str_replace('_', ' ', $key);
            $error[] = "Please fill $key fields";
            break;
        }
    }

    if (empty($error) == false){
        echo json_encode(['status' => 0, 'message' => $error]);
    } else{
        if ($email == false){
            echo json_encode(['status' => 0, 'message' => 'Email syntax un valid']);
            return false;
        }

        $sql = "SELECT email FROM teachers WHERE email = '$email' OR phone = '$phone'";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows>0){
            echo json_encode(['status' => 0, 'message' => 'Email or phone has been used before']);
            return false;
        }

        if (empty($phone) == true){
            echo json_encode(['status' => 0, 'message' => 'Phone syntax un valid']);
            return false;
        }


        if($result->num_rows>0){
            echo json_encode(['status' => 0, 'message' => 'Phone has been used before']);
            return false;
        }

        if ($password != $confirm_password){
            echo json_encode(['status' => 0, 'message' => 'Passwords not equals']);
            return false;
        }

        $password = password_hash($password, CRYPT_BLOWFISH);
        $sql = "INSERT INTO teachers SET name='$name', email='$email', phone='$phone', password='$password'";
        $result = mysqli_query($conn, $sql);
        echo json_encode(['status' => 1, 'message' => 'Teacher added successfully']);
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}