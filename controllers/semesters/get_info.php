<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

   $id = (int) $_GET['id'];

   $sql = "SELECT * FROM semesters WHERE id = '$id'";
   $query = mysqli_query($conn, $sql);
   $semester = $query->fetch_assoc();
}
?>
<input type="hidden" name="id" value="<?=$semester['id']?>">
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="name">Name</label>
        <input type="text" id="name" class="form-control" name="name" value="<?=$semester['name']?>">
    </div>
</div>
