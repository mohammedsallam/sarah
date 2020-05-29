<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../connection.php';

    $table = '';
    $id = $_POST['id'];
    $password = $_POST['password'];
    $conf_password = $_POST['confirm_password'];

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
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $error = [];

            foreach ($_POST as $key => $item) {
                if ($key == 'password' || $key == 'confirm_password'){
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
                exit();
            }

            if ($password != $conf_password){
                echo json_encode(['status' => 0, 'message' => 'Passwords not equals']);
                exit();
            }
            if (empty($password) == false){
                $password = password_hash($password, CRYPT_BLOWFISH);
                $sql = "UPDATE $table SET name = '$name', password = '$password' WHERE id = '$id'";
            } else {
                $sql = "UPDATE $table SET name = '$name' WHERE id = '$id'";
            }

            $result = mysqli_query($conn, $sql);
            echo json_encode(['status' => 1, 'message' => 'Profile updated successfully']);
        } elseif ($_POST['type'] == '2'){
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
            $error = [];

            foreach ($_POST as $key => $item) {
                if ($key == 'password' || $key == 'confirm_password'){
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
                exit();
            }

            if ($password != $conf_password){
                echo json_encode(['status' => 0, 'message' => 'Passwords not equals']);
                exit();
            }
            if (empty($password) == false){
                $password = password_hash($password, CRYPT_BLOWFISH);
                $sql = "UPDATE $table SET name = '$name', last_name = '$last_name', password = '$password' WHERE id = '$id'";
            } else {
                $sql = "UPDATE $table SET name = '$name', last_name = '$last_name' WHERE id = '$id'";
            }

            $result = mysqli_query($conn, $sql);
            echo json_encode(['status' => 1, 'message' => 'Profile updated successfully']);
        }



    }
} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}
