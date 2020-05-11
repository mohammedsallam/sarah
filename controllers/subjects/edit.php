<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $id = (int) $_POST['id'];
    $name = $_POST['name'];
    $semester = $_POST['semester'];
    $credit = $_POST['credit'];
    $section_id = filter_var($_POST['section_id'], FILTER_SANITIZE_NUMBER_INT);
    $year_id = filter_var($_POST['year_id'], FILTER_SANITIZE_NUMBER_INT);
    $teacher_id = filter_var($_POST['teacher_id'], FILTER_SANITIZE_NUMBER_INT);
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


        $sql = "UPDATE subjects SET name='$name', year_id='$year_id', teacher_id='$teacher_id', section_id ='$section_id', credit ='$credit', semester='$semester' WHERE id ='$id'";
        $result = mysqli_query($conn, $sql);
       
        echo json_encode(['status' => 1, 'message' => 'Subject Updated successfully']);
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}