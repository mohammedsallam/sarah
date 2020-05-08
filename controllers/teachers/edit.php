<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $id = (int) $_POST['id'];
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $error = [];

    foreach ($_POST as $key => $item) {
        if (array_key_exists('password', $_POST)){
            continue;
        }
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

        $sql = "SELECT email, phone FROM teachers WHERE id != '$id' AND (email = '$email' OR phone = '$phone')";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows>0){
            echo json_encode(['status' => 0, 'message' => 'Email or phone has been used before']);
            return false;
        }

        if (empty($phone) == true){
            echo json_encode(['status' => 0, 'message' => 'Phone syntax un valid']);
            return false;
        }

        if ($password != $confirm_password){
            echo json_encode(['status' => 0, 'message' => 'Passwords not equals']);
            return false;
        }

       if (empty($password) == false){
           $hashPassword = password_hash($password, CRYPT_BLOWFISH);
           $sql = "UPDATE teachers SET name='$name', last_name = '$last_name', username = '$username', email='$email', phone='$phone', password = '$hashPassword' WHERE id ='$id'";

       } else {
           $sql = "UPDATE teachers SET name='$name', last_name = '$last_name', username = '$username',email='$email', phone='$phone' WHERE id ='$id'";
       }

        $result = mysqli_query($conn, $sql);
        echo json_encode(['status' => 1, 'message' => 'Teacher Updated successfully']);
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}