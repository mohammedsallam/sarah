<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $fees_id = @$_REQUEST['fees_id'];
    $fees = $_REQUEST['fees'];
    $fees_type = $_REQUEST['fees_type'];
    $ticket = $_REQUEST['ticket'];
    $year_id = $_REQUEST['year_id'];
    $student_id = $_REQUEST['student_id'];
    $error = [];

    foreach ($_REQUEST as $key => $item) {
        if (empty($item)){
            $key = str_replace('_', ' ', $key);
            $error[] = "Please fill $key fields";
            break;
        }
    }

    if (empty($error) == false){
        echo json_encode(['status' => 0, 'message' => $error]);
    } else{

        $sql = "SELECT * FROM fees WHERE student_id = '$student_id' AND year_id = '$year_id' AND id = '$fees_id'";
        $result = mysqli_query($conn, $sql);
        $rows = $result->num_rows;
//        var_dump($result);
//        exit();
        if($rows > 0){
            $error = 'Fees added before for this year';
            $sql = "UPDATE fees SET year_id = '$year_id', student_id='$student_id', fees = '$fees', ticket = '$ticket', fees_type = '$fees_type' WHERE student_id = '$student_id' AND year_id = '$year_id' AND id = '$fees_id'";
            $result = mysqli_query($conn, $sql);
            echo json_encode(['status' => 1, 'message' => 'Fees Updated successfully']);
            exit();
        }

        $sql = "INSERT INTO fees SET year_id = '$year_id', student_id='$student_id', fees = '$fees', ticket = '$ticket', fees_type = '$fees_type'";
        $result = mysqli_query($conn, $sql);
        echo json_encode(['status' => 1, 'message' => 'Fees added successfully']);
    }
} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}