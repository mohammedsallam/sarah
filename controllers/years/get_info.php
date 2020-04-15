<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

   $id = (int) $_GET['id'];

   $sql = "SELECT * FROM years WHERE id = '$id'";
   $query = mysqli_query($conn, $sql);
   $year = $query->fetch_assoc();
}
?>
<input type="hidden" name="id" value="<?=$year['id']?>">
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="name">Name</label>
        <input type="text" id="name" class="form-control" name="name" value="<?=$year['name']?>">
    </div>
</div>
