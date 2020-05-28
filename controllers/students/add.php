<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
//    $fess = filter_var($_POST['fees'], FILTER_SANITIZE_NUMBER_INT);
//    $payed = filter_var($_POST['payed'], FILTER_SANITIZE_NUMBER_INT);
//    $remaining = filter_var($_POST['remaining'], FILTER_SANITIZE_NUMBER_INT);
    $section_id = filter_var($_POST['section_id'], FILTER_SANITIZE_NUMBER_INT);
    $year_id = filter_var($_POST['year_id'], FILTER_SANITIZE_NUMBER_INT);
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

        $sql = "SELECT email FROM students WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows>0){
            echo json_encode(['status' => 0, 'message' => 'Email has been used before']);
            return false;
        }


        if ($password != $confirm_password){
            echo json_encode(['status' => 0, 'message' => 'Passwords not equals']);
            return false;
        }

        $password = password_hash($password, CRYPT_BLOWFISH);
        $sql = "INSERT INTO students SET name='$name', last_name = '$last_name', username = '$username', email='$email', password='$password', year_id = '$year_id', section_id = '$section_id'";
        $result = mysqli_query($conn, $sql);
//        $student_id = mysqli_insert_id($conn);
//        $sql = "INSERT INTO fees SET student_id='$student_id', section_id='$section_id', fees='$fess', payed='$payed', remaining = '$remaining'";
//        $result = mysqli_query($conn, $sql);

        echo json_encode(['status' => 1, 'message' => 'Student added successfully']);
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}