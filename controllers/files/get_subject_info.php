<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

    $subject_id = filter_var($_GET['subject_id'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT subjects.semester, years.name, years.id AS year_id FROM subjects 
            LEFT JOIN years ON years.id=subjects.year_id WHERE subjects.id='$subject_id'";
    $result = mysqli_query($conn, $sql);
    $subjectInfo = $result->fetch_all(MYSQLI_ASSOC);
    $subjectInfo = array_shift($subjectInfo);
    echo json_encode($subjectInfo);
} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}