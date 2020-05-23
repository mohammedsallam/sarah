<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';
    $id = (int) $_GET['id'];
    $file =  $_GET['file'];

    $file = APP_DIR.$file;

    if (file_exists($file)){

        if (unlink($file)){
            $sql = "DELETE FROM exams WHERE id = '$id'";
            $query = mysqli_query($conn, $sql);
            echo json_encode(['status' => 1, 'message' => "Exam Number $id Deleted successfully"]);
        } else{
            echo json_encode(['status' => 0, 'message' => "Exam Can not be delete"]);
        }

    } else {
        echo json_encode(['status' => 0, 'message' => "File Not Found"]);
    }



}