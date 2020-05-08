<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $name = $_POST['name'];
    $fees = $_POST['fees'];
    $year_id = @$_POST['year_id'];
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

        if (!array_key_exists('year_id', $_POST)){
            $error = "Please choose years fields";
            echo json_encode(['status' => 0, 'message' => $error]);
            exit();
        }


        $sql = "INSERT INTO sections SET name='$name', fees = '$fees'";
        $result = mysqli_query($conn, $sql);
        $section_id = mysqli_insert_id($conn);
        foreach ($_POST['year_id'] as $year) {
            $sql = "INSERT INTO section_years SET year_id = '$year', section_id = '$section_id'";
            $result = mysqli_query($conn, $sql);
        }

        echo json_encode(['status' => 1, 'message' => 'Section added successfully']);
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}