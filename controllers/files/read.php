<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

    $id = $_GET['file'];

    $sql = "SELECT file FROM subject_files WHERE id ='$id'";
    $result = mysqli_query($conn, $sql);
    $file = $result->fetch_all(MYSQLI_ASSOC);
    $file = array_shift($file);

    header('Content-type: application/pdf');
    readfile(APP.$file['file']);

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}