<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $session = $_REQUEST['session'];
    $section_id = filter_var($_REQUEST['section_id'], FILTER_SANITIZE_NUMBER_INT);
    $year_id = filter_var($_REQUEST['year_id'], FILTER_SANITIZE_NUMBER_INT);
    $student_id = filter_var($_REQUEST['student_id'], FILTER_SANITIZE_NUMBER_INT);
    $subject_id = filter_var($_REQUEST['subject_id'], FILTER_SANITIZE_NUMBER_INT);
    $mark = filter_var($_REQUEST['mark'], FILTER_SANITIZE_NUMBER_INT);
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

        $sql = "SELECT * FROM marks WHERE student_id = '$student_id' AND section_id = '$section_id' AND subject_id = '$subject_id' AND year_id = '$year_id'";
        $result = mysqli_query($conn, $sql);
        $rows = $result->num_rows;

        if($rows > 0){
            $error = 'Mark added before for this subject';
            $sql = "UPDATE marks SET session='$session', section_id = '$section_id', year_id = '$year_id', 
                    student_id='$student_id', 
                    subject_id='$subject_id', 
                    mark = '$mark'
                    WHERE student_id = '$student_id' 
                    AND section_id = '$section_id' 
                    AND subject_id = '$subject_id' 
                    AND year_id = '$year_id' ";
            $result = mysqli_query($conn, $sql);
            echo json_encode(['status' => 1, 'message' => 'Mark Updated successfully']);

            exit();
        }

        $sql = "INSERT INTO marks SET session='$session', section_id = '$section_id', year_id = '$year_id', student_id='$student_id', subject_id='$subject_id', mark = '$mark'";
        $result = mysqli_query($conn, $sql);
        echo json_encode(['status' => 1, 'message' => 'Mark added successfully']);
    }
} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}