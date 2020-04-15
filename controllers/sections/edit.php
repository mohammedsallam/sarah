<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $id = (int) $_POST['id'];
    $fees = (int) $_POST['fees'];
    $name = $_POST['name'];
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

        $sql = "UPDATE sections SET name='$name', fees = '$fees' WHERE id ='$id'";
        $result = mysqli_query($conn, $sql);
        echo json_encode(['status' => 1, 'message' => 'Section Updated successfully']);
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}