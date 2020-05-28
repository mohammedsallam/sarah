<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

   $id = (int) $_GET['id'];

   $sql = "SELECT * FROM teachers WHERE id = '$id'";
   $query = mysqli_query($conn, $sql);
   $teacher = $query->fetch_assoc();

    $sql = "SELECT * FROM sections";
    $result = mysqli_query($conn, $sql);
    $sections = $result->fetch_all(MYSQLI_ASSOC);

    $section_id = $teacher['section_id'];
    $sql = "SELECT section_years.*, years.name FROM section_years 
            LEFT JOIN years on years.id=section_years.year_id 
            WHERE section_years.section_id = '$section_id' GROUP BY years.id";
    $result = mysqli_query($conn, $sql);
    $years = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<input type="hidden" name="id" value="<?=$teacher['id']?>">
<div class="form-row">
    <div class="form-group col-md-4">
        <label for="name">Name</label>
        <input type="text" id="name" class="form-control" name="name" value="<?=$teacher['name']?>">
    </div>
    <div class="form-group col-md-4">
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" class="form-control" name="last_name" value="<?=$teacher['last_name']?>">
    </div>
    <div class="form-group col-md-4">
        <label for="username">User Name</label>
        <input type="text" id="username" class="form-control" name="username" value="<?=$teacher['username']?>">
    </div>
    <div class="form-group col-md-3">
        <label for="email">E-mail</label>
        <input type="email" id="email" class="form-control" name="email" value="<?=$teacher['email']?>">
    </div>
    <div class="form-group col-md-3">
        <label for="phone">Phone</label>
        <input type="tel" id="phone" class="form-control" name="phone" value="<?=$teacher['phone']?>">
    </div>
    <div class="form-group col-md-3">
        <label for="phone">Section</label>
        <select name="section_id" class="form-control section_id">
            <option value="">Select </option>
            <?php
            foreach ($sections as $section) { ?>
                <option <?= $teacher['section_id'] == $section['id'] ? 'selected' : ''?> value="<?=$section['id']?>"><?=$section['name']?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-3">
        <label for="phone">year</label>
        <select name="year_id" class="form-control year_id">
            <option value="">Select </option>
            <?php
            foreach ($years as $year) { ?>
                <option <?= $teacher['year_id'] == $year['year_id'] ? 'selected' : ''?> value="<?=$year['year_id']?>"><?=$year['name']?></option>
            <?php } ?>
        </select>
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
