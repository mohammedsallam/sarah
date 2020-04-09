<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../connection.php';

    $table = '';
    $redirect = '';
    $email = $_POST['email'];
    $password = $_POST['password'];

    switch ($_POST['sign_type']){
        case '1':
            $table = 'admins';
            $redirect = '/admins/index.php';
            break;
        case '2':
            $table = 'teachers';
            $redirect = '/teachers/index.php';
            break;
        case '3':
            $table = 'students';
            $redirect = '/students/index.php';
            break;
    }

    $query = "SELECT * FROM $table WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $fetch = $result->fetch_object();
    if (empty($fetch) == false){
        $pass = password_verify($password, $fetch->password);
        if ($pass){
            var_dump($pass);
            $_SESSION['id'] = $fetch->id;
            $_SESSION['name'] = $fetch->name;
            $_SESSION['email'] = $fetch->email;
            $_SESSION['sign_type'] = $_POST['sign_type'];
            $_SESSION['location'] = APP.$redirect;
            header('location: '.APP.$redirect);
        } else {
            $_SESSION['message'] = 'Credential error';
            header('location: '. $_SERVER['HTTP_REFERER']);
            exit();
        }
    } else {
        $_SESSION['message'] = 'There is no data';
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}