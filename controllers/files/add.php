<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $name = $_POST['name'];
    $section_id = filter_var($_POST['section_id'], FILTER_SANITIZE_NUMBER_INT);
    $subject_id = filter_var($_POST['subject_id'], FILTER_SANITIZE_NUMBER_INT);
    $year_id = filter_var($_POST['year_id'], FILTER_SANITIZE_NUMBER_INT);
    $semester = $_POST['semester'];
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

        $path = '';

        $allow_file  = [
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/x-msaccess',
            'application/pdf',
            'image/jpeg',
            'image/png',
            'image/gif',
        ];

        if ($file['name'] !=  ''){
            $allow_ext  = array('jpg','jpeg','png','gif', 'pdf', 'doc', 'docx', 'ppt','pptx', 'accdb', 'xlsx');
            $ext = explode('.', $file['name']);
            $ext = end($ext);
            $ext = strtolower($ext);
            $mime = mime_content_type($file['tmp_name']);
            if (!in_array($mime, $allow_file)){
                $error = 'Un allowed file type';
                echo json_encode(['status' => 0, 'message' => $error]);
                exit();
            }

            if(in_array($ext,$allow_ext)) {
                $new_name = time().'.'.$ext;
                $path = '/uploads/subjects/' . $new_name;
                move_uploaded_file($file['tmp_name'], APP_DIR.$path);
            } else {
                $error = 'File extension not allowed';
                echo json_encode(['status' => 0, 'message' => $error]);
                exit();
            }
        } else {
            $error = 'Please choose file';
            echo json_encode(['status' => 0, 'message' => $error]);
            exit();
        }


        $sql = "INSERT INTO subject_files SET name='$name', semester='$semester', year_id = '$year_id', section_id = '$section_id', subject_id='$subject_id', file='$path'";
        $result = mysqli_query($conn, $sql);
        echo json_encode(['status' => 1, 'message' => 'File added successfully']);
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}