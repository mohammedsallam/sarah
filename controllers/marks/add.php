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

    $sql = "SELECT * FROM marks WHERE student_id='$student_id' AND subject_id='$subject_id'";
    $result = mysqli_query($conn, $sql);
    $count = $result->num_rows;
    if ($count > 0) {
        $sql = "UPDATE marks SET mark = '$mark', session='$session', year_id = '$year_id', section_id = '$section_id', subject_id='$subject_id', student_id='$student_id' 
                WHERE student_id='$student_id' AND subject_id='$subject_id'";
    } else {
        $sql = "INSERT INTO marks SET mark = '$mark', session='$session', year_id = '$year_id', section_id = '$section_id', subject_id='$subject_id', student_id='$student_id'";

    }

    $result = mysqli_query($conn, $sql);
    echo json_encode(['status' => 1, 'message' => 'Mark added successfully']);

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}