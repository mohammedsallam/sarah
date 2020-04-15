<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

   $id = (int) $_GET['id'];

   $sql = "SELECT * FROM sections WHERE id = '$id'";
   $query = mysqli_query($conn, $sql);
   $section = $query->fetch_assoc();
}
?>
<input type="hidden" name="id" value="<?=$section['id']?>">
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="name">Name</label>
        <input type="text" id="name" class="form-control" name="name" value="<?=$section['name']?>">
    </div>
    <div class="form-group col-md-12">
        <label for="fees">Fees</label>
        <input type="number" id="fees" min="0" class="form-control" name="fees" value="<?=$section['fees']?>">
    </div>
</div>
