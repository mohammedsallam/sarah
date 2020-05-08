<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

   $id = (int) $_GET['id'];

   $sql = "SELECT * FROM teachers WHERE id = '$id'";
   $query = mysqli_query($conn, $sql);
   $student = $query->fetch_assoc();
}
?>
<input type="hidden" name="id" value="<?=$student['id']?>">
<div class="form-row">
    <div class="form-group col-md-4">
        <label for="name">Name</label>
        <input type="text" id="name" class="form-control" name="name" value="<?=$student['name']?>">
    </div>
    <div class="form-group col-md-4">
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" class="form-control" name="last_name" value="<?=$student['last_name']?>">
    </div>
    <div class="form-group col-md-4">
        <label for="username">User Name</label>
        <input type="text" id="username" class="form-control" name="username" value="<?=$student['username']?>">
    </div>
    <div class="form-group col-md-6">
        <label for="email">E-mail</label>
        <input type="email" id="email" class="form-control" name="email" value="<?=$student['email']?>">
    </div>
    <div class="form-group col-md-6">
        <label for="phone">Phone</label>
        <input type="tel" id="phone" class="form-control" name="phone" value="<?=$student['phone']?>">
    </div>
    <div class="form-group col-md-6">
        <label for="password">Password</label>
        <input type="password" id="password" class="form-control" name="password">
    </div>
    <div class="form-group col-md-6">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" class="form-control" name="confirm_password">
    </div>
</div>
