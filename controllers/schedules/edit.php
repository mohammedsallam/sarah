<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $id = (int) $_POST['id'];
    $name = $_POST['name'];
    $file = $_FILES['file'];
    $old_file = $_POST['old_file'];
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
//            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
//            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
//            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
//            'application/vnd.ms-powerpoint',
//            'application/x-msaccess',
            'application/pdf',
//            'image/jpeg',
//            'image/png',
//            'image/gif',
        ];

        if ($file['name'] !=  ''){
            $sql = '';
//            $allow_ext  = array('jpg','jpeg','png','gif', 'pdf', 'doc', 'docx', 'ppt','pptx', 'accdb', 'xlsx');
            $allow_ext  = array('pdf');
            $ext = explode('.', $file['name']);
            $ext = end($ext);
            $ext = strtolower($ext);
            $mime = mime_content_type($file['tmp_name']);

            if (!in_array($mime, $allow_file)){
                $error = 'Un allowed file type please choose PDF file';
                echo json_encode(['status' => 0, 'message' => $error]);
                exit();
            }

            if(in_array($ext,$allow_ext)) {
                $new_name = time().'.'.$ext;
                $path = '/uploads/schedules/' . $new_name;
                move_uploaded_file($file['tmp_name'], APP_DIR.$path);

            } else {
                $error = 'File extension not allowed';
                echo json_encode(['status' => 0, 'message' => $error]);
                exit();
            }

            $sql = "UPDATE schedules SET name='$name', file='$path' WHERE id='$id'";


            if (file_exists(APP_DIR.$old_file)){
                unlink(APP_DIR.$old_file);
            }

        } else {
            $sql = "UPDATE schedules SET name='$name' WHERE id='$id'";
        }
        $result = mysqli_query($conn, $sql);
        echo json_encode(['status' => 1, 'message' => 'File Updated successfully']);
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}