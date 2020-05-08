<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

    $year_id = @$_GET['year_id'];
    $student_id = @$_GET['student_id'];
    $section_id = @$_GET['section_id'];
    $subject_id = @$_GET['subject_id'];

    $sql = "SELECT * FROM  marks WHERE 
                    student_id = '$student_id' 
                    AND section_id = '$section_id' 
                    AND subject_id = '$subject_id' 
                    AND year_id = '$year_id'";
    $result = mysqli_query($conn, $sql);
    $marks = $result->fetch_assoc();

    $sql = "SELECT * FROM years WHERE id = '$year_id'";
    $result = mysqli_query($conn, $sql);
    $years = $result->fetch_assoc();

    $sql = "SELECT subjects.* FROM subjects WHERE year_id = '$year_id' ";
    $result = mysqli_query($conn, $sql);
    $subjects = $result->fetch_all(MYSQLI_ASSOC);

    ?>

    <input type="hidden" name="section_id" value="<?=@$_GET['section_id']?>">
    <input type="hidden" name="year_id" value="<?=@$_GET['year_id']?>">
    <input type="hidden" name="student_id" value="<?=@$_GET['student_id']?>">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="name">Year</label>
            <input readonly type="text" id="name" value="<?=$years['name']?>" class="form-control bg-white">
        </div>
        <div class="form-group col-md-3">
            <label for="subject_id">Subject</label>
            <select name="subject_id" id="subject_id" class="form-control">
                <?php
                foreach ($subjects as $subject) { ?>
                    <option <?php if($subject['id'] == $subject_id) { echo 'selected'; }?> value="<?= $subject['id']?>"><?= $subject['name']?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="mark">Mark</label>
            <input type="number" min="0" id="mark" class="form-control" name="mark" value="<?=$marks['mark']?>">
        </div>
        <div class="form-group col-md-3">
            <label for="session">Session</label>
            <select name="session" id="session" class="form-control">
                <option <?php if($marks['session'] == 'semester') { echo 'selected'; }?>  value="semester">Semester</option>
                <option <?php if($marks['session'] == 're_exam') { echo 'selected'; }?> value="re_exam">Re-Exam</option>
            </select>
        </div>
    </div>

<?php } else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}