<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $name = $_POST['name'];
    $section_id = filter_var($_POST['section_id'], FILTER_SANITIZE_NUMBER_INT);
    $year_id = filter_var($_POST['year_id'], FILTER_SANITIZE_NUMBER_INT);
    $teacher_id = filter_var($_POST['teacher_id'], FILTER_SANITIZE_NUMBER_INT);
    $file = $_FILES['file'];
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

        if ($file){
            $allow_ext  = array('jpg','jpeg','png','gif', 'pdf', 'doc', 'docx');
            $ext = explode('.', $file['name']);
            $ext = end($ext);
            $ext = strtolower($ext);
            if(in_array($ext,$allow_ext)) {
                $new_name = time().'.'.$ext;
                move_uploaded_file($file['tmp_name'], APP.'uploads/subjects/' . $new_name);
            } else {
                $error[] = 'Un allowed file type';
                echo json_encode(['status' => 0, 'message' => $error]);
                exit();
            }
        }


        $sql = "INSERT INTO subjects SET name='$name', email='$email', password='$password', year_id = '$year_id', section_id = '$section_id'";
        $result = mysqli_query($conn, $sql);
        $student_id = mysqli_insert_id($conn);
        $sql = "INSERT INTO fees SET student_id='$student_id', section_id='$section_id', fees='$fess', payed='$payed', remaining = '$remaining'";
        $result = mysqli_query($conn, $sql);

        echo json_encode(['status' => 1, 'message' => 'Student added successfully']);
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}