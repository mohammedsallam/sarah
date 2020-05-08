<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

    $fees_id = @$_GET['fees_id'];
    $year_id = @$_GET['year_id'];
    $student_id = @$_GET['student_id'];

    $sql = "SELECT * FROM  fees where year_id = '$year_id' AND student_id = '$student_id' AND id = '$fees_id'";
    $result = mysqli_query($conn, $sql);
    $fees = $result->fetch_assoc();

    $sql = "SELECT * FROM years WHERE id = '$year_id'";
    $result = mysqli_query($conn, $sql);
    $years = $result->fetch_assoc();


    ?>

    <input type="hidden" name="year_id" value="<?=@$_GET['year_id']?>">
    <input type="hidden" name="fees_id" value="<?=@$fees_id?>">
    <input type="hidden" name="student_id" value="<?=@$_GET['student_id']?>">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="name">Year</label>
            <input readonly type="text" id="name" value="<?=$years['name']?>" class="form-control bg-white">
        </div>
        <div class="form-group col-md-3">
            <label for="fees">Amount</label>
            <input name="fees" id="fees" type="number" min="0" class="form-control" value="<?= $fees['fees'] ?>">
        </div>
        <div class="form-group col-md-3">
            <label for="type">Fee type</label>
            <select name="fees_type" id="type" class="form-control">
                <option value="">select</option>
                <option <?php if ($fees['fees_type'] == 'Integral fee paid') { echo 'selected'; }?> value="Integral fee paid">Integral fee paid</option>
                <option <?php if ($fees['fees_type'] == 'Rate 1') { echo 'selected'; }?> value="Rate 1">Rate 1</option>
                <option <?php if ($fees['fees_type'] == 'Rate 2') { echo 'selected'; }?> value="Rate 2">Rate 2</option>
                <option <?php if ($fees['fees_type'] == 'Rate 3') { echo 'selected'; }?> value="Rate 3">Rate 3</option>
                <option <?php if ($fees['fees_type'] == 'Rate 4') { echo 'selected'; }?> value="Rate 4">Rate 4</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="ticket">Ticket Nr</label>
            <input name="ticket" id="ticket" type="number" min="0" class="form-control" value="<?= $fees['ticket'] ?>">
        </div>
    </div>

<?php } else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}