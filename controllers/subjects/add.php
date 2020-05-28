<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';

    $name = $_POST['name'];
    $semester = $_POST['semester'];
    $credit = $_POST['credit'];
    $section_id = filter_var($_POST['section_id'], FILTER_SANITIZE_NUMBER_INT);
    $year_id = filter_var($_POST['year_id'], FILTER_SANITIZE_NUMBER_INT);
    $teacher_id = filter_var($_POST['teacher_id'], FILTER_SANITIZE_NUMBER_INT);
    $error = [];


    foreach ($_POST as $key => $item) {
        if (empty($item)){
            $key = str_replace('_', ' ', $key);
            $error[] = "Please fill $key fields";
            break;
        }
    }

    $creditArray = [0,1,2,3,4,5];

    if (!in_array($credit, $creditArray)){
        $error = "Credit must be between 0-5";
        echo json_encode(['status' => 0, 'message' => $error]);
        exit();
    }

    if (empty($error) == false){
        echo json_encode(['status' => 0, 'message' => $error]);
    } else{

//        if ($file){
//            $allow_ext  = array('jpg','jpeg','png','gif', 'pdf', 'doc', 'docx');
//            $ext = explode('.', $file['name']);
//            $ext = end($ext);
//            $ext = strtolower($ext);
//            if(in_array($ext,$allow_ext)) {
//                $new_name = time().'.'.$ext;
//                move_uploaded_file($file['tmp_name'], APP.'uploads/subjects/' . $new_name);
//            } else {
//                $error[] = 'Un allowed file type';
//                echo json_encode(['status' => 0, 'message' => $error]);
//                exit();
//            }
//        }


        $sql = "INSERT INTO subjects SET name='$name', teacher_id='$teacher_id', semester='$semester', credit='$credit', year_id = '$year_id', section_id = '$section_id'";
        $result = mysqli_query($conn, $sql);
        echo json_encode(['status' => 1, 'message' => 'Subject added successfully']);
    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}