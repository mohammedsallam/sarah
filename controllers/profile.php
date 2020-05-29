<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../connection.php';

    $table = '';
    $id = $_POST['id'];
    switch ($_POST['type']){
        case '1':
            $table = 'admins';
            break;
        case '2':
            $table = 'teachers';
            break;
        case '3':
            $table = 'students';
            break;
    }

    $query = "SELECT * FROM $table WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $fetch = $result->fetch_object();
    if (empty($fetch) == false){
        if ($_POST['type'] == '1'){

        } elseif ($_POST['type'] == '2'){

        } else {

            $password = $_POST['password'];
            $conf_password = $_POST['confirm_password'];
            if (empty($password) == true || empty($conf_password) == true){
                echo json_encode(['status' => 0, 'message' => 'Please fill passwords fields']);
                exit();
            }
            if ($password != $conf_password){
                echo json_encode(['status' => 0, 'message' => 'Passwords not equals']);
                exit();
            }
            $password = password_hash($password, CRYPT_BLOWFISH);
            $sql = "UPDATE $table SET password = '$password' WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);
            echo json_encode(['status' => 1, 'message' => 'Password updated successfully']);
        }



    }
} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}
