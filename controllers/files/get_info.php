<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

   $id = (int) $_GET['id'];
   $file = $_GET['file'];

    $sql = "SELECT * FROM subject_files WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $subject_file = $result->fetch_all(MYSQLI_ASSOC);
    $subject_file = array_shift($subject_file);

}
?>
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="old_file" value="<?=$file?>">
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="name">File Name</label>
        <input type="text" id="name" class="form-control" name="name" value="<?=$subject_file['name']?>">
    </div>
    <div class="form-group col-md-6 pt-2">
        <label for="file" class="btn btn-info btn-block mt-4"><i class="fa fa-file"></i> Choose file</label>
        <input type="file" id="file" name="file" class="d-none">
    </div>
</div>

