<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';
    $id = (int) $_GET['id'];
    $sql = "DELETE FROM sections WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);
    echo json_encode(['status' => 1, 'message' => "Section Number $id Deleted successfully"]);

}