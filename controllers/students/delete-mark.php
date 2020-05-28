<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

    $id = filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "DELETE FROM marks WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

        echo json_encode(['status' => 1, 'message' => "Mark Number $id Deleted successfully"]);

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}