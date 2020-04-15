<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

   $id = (int) $_GET['id'];

   $sql = "SELECT students.*, fees.* FROM students LEFT JOIN fees ON students.id=fees.student_id WHERE students.id = '$id'";
   $query = mysqli_query($conn, $sql);
   $student = $query->fetch_assoc();

    $sectionSql = "SELECT * FROM sections";
    $result = mysqli_query($conn, $sectionSql);
    $sections = $result->fetch_all(MYSQLI_ASSOC);

    $yearsSql = "SELECT * FROM years";
    $result = mysqli_query($conn, $yearsSql);
    $years = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<input type="hidden" name="id" value="<?=$id?>">
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="name">Name</label>
        <input type="text" id="name" class="form-control" name="name" value="<?=$student['name']?>">
    </div>
    <div class="form-group col-md-6">
        <label for="email">E-mail</label>
        <input type="email" id="email" class="form-control" name="email" value="<?=$student['email']?>">
    </div>
    <div class="form-group col-md-6">
        <label for="password">Password</label>
        <input type="password" id="password" class="form-control" name="password" >
    </div>
    <div class="form-group col-md-6">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" class="form-control" name="confirm_password">
    </div>
    <div class="form-group col-md-2">
        <label for="fees">Fees</label>
        <input type="number" id="fees" class="form-control" name="fees" min="0" value="<?=$student['fees']?>">
    </div>
    <div class="form-group col-md-2">
        <label for="payed">Payed fees</label>
        <input type="number" id="payed" class="form-control" name="payed" min="0" value="<?=$student['payed']?>">
    </div>
    <div class="form-group col-md-2">
        <label for="phone">Remaining fees</label>
        <input readonly type="number" id="remaining" class="form-control bg-white" name="remaining" min="0" value="<?=$student['remaining']?>">
    </div>
    <div class="form-group col-md-3">
        <label for="section_id">Section</label>
        <select name="section_id" id="section_id" class="form-control">
            <?php
            foreach ($sections as $section) { ?>
                <option <?= $student['section_id'] == $section['id'] ? 'selected' : '' ?> value="<?= $section['id']?>"><?= $section['name']?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-3">
        <label for="year_id">Year</label>
        <select name="year_id" id="year_id" class="form-control">
            <?php
            foreach ($years as $year) { ?>
                <option <?= $student['year_id'] == $year['id'] ? 'selected' : '' ?> value="<?= $year['id']?>"><?= $year['name']?></option>
            <?php } ?>
        </select>
    </div>

</div>

<script>
    $(document).ready(function () {
        $('#fees, #payed').keydown(function(){
            let fees = $('#fees'), payed = $('#payed'), remaining = $('#remaining');
            remaining.val(parseFloat(fees.val())-parseFloat(payed.val()));
        })
    })
</script>
