<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $id = (int) $_POST['id'];
    $name = $_POST['name'];
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $fess = filter_var($_POST['fees'], FILTER_VALIDATE_FLOAT);
    $payed = filter_var($_POST['payed'], FILTER_VALIDATE_FLOAT);
    $remaining = filter_var($_POST['remaining'], FILTER_VALIDATE_FLOAT);
    $section_id = filter_var($_POST['section_id'], FILTER_SANITIZE_NUMBER_INT);
    $year_id = filter_var($_POST['year_id'], FILTER_SANITIZE_NUMBER_INT);
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

        $sql = "SELECT email FROM teachers WHERE id != '$id' AND email = '$email'";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows>0){
            echo json_encode(['status' => 0, 'message' => 'Email has been used before']);
            return false;
        }

        if ($password != $confirm_password){
            echo json_encode(['status' => 0, 'message' => 'Passwords not equals']);
            return false;
        }

       if (empty($password) == false){
           $hashPassword = password_hash($password, CRYPT_BLOWFISH);
           $sql = "UPDATE students SET name='$name', email='$email', password='$password', year_id = '$year_id', section_id = '$section_id' WHERE id ='$id'";


       } else {
           $sql = "UPDATE students SET name='$name', email='$email', year_id = '$year_id', section_id = '$section_id' WHERE id ='$id'";
       }

        $result = mysqli_query($conn, $sql);
        $sql = "SELECT * FROM fees WHERE student_id = '$id'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0){
            $sql = "UPDATE fees SET student_id='$id', fees='$fess', payed='$payed', remaining = '$remaining' WHERE student_id = '$id'";
            $result = mysqli_query($conn, $sql);
        } else {
            $sql = "INSERT INTO fees SET student_id='$id', fees='$fess', payed='$payed', remaining = '$remaining'";
            $result = mysqli_query($conn, $sql);
        }
        echo json_encode(['status' => 1, 'message' => 'Student Updated successfully']);
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}