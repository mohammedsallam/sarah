<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

   $id = (int) $_GET['id'];
   $section_id = (int) $_GET['section_id'];

    $sql = "SELECT subjects.*, 
        years.name AS YNAME, 
        years.id AS YID,
        teachers.name AS TNAME, 
        teachers.id AS TID, 
        sections.name AS SNAME,
        sections.id AS SID
        FROM subjects LEFT JOIN years ON years.id=subjects.year_id 
        LEFT JOIN teachers ON teachers.id=subjects.teacher_id 
        LEFT JOIN sections ON sections.id=subjects.section_id 
        WHERE subjects.id = '$id'";

    $result = mysqli_query($conn, $sql);
    $subject = $result->fetch_all(MYSQLI_ASSOC);
    $subject = array_shift($subject);

    $sectionSql = "SELECT * FROM sections";
    $result = mysqli_query($conn, $sectionSql);
    $sections = $result->fetch_all(MYSQLI_ASSOC);

//    $year_id = $subject['YID'];
    $yearsSql = "SELECT section_years.*, years.name FROM section_years 
            LEFT JOIN years on years.id=section_years.year_id 
            WHERE section_years.section_id = '$section_id' GROUP BY years.id";
    $result = mysqli_query($conn, $yearsSql);
    $years = $result->fetch_all(MYSQLI_ASSOC);


    $teacherSql = "SELECT * FROM teachers";
    $result = mysqli_query($conn, $teacherSql);
    $teachers = $result->fetch_all(MYSQLI_ASSOC);

    $yearsSql = "SELECT * FROM semesters";
    $result = mysqli_query($conn, $yearsSql);
    $semesters = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<input type="hidden" name="id" value="<?=$id?>">
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="name">Subject Name</label>
        <input type="text" id="name" class="form-control" name="name" value="<?=$subject['name']?>">
    </div>
    <div class="form-group col-md-6">
        <label for="teacher_id">Teacher</label>
        <select name="teacher_id" id="teacher_id" class="form-control teacher_id">
            <option value="">Select teacher</option>
            <?php
            foreach ($teachers as $teacher) { ?>
                <option <?= $subject['teacher_id'] == $teacher['id'] ? 'selected' : ''?> value="<?= $teacher['id']?>"><?= $teacher['name']?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="section_id">Department</label>
        <input type="text" class="form-control bg-white" readonly  value="<?=$subject['SNAME']?>">
        <input type="hidden" name="section_id" value="<?=$subject['SID']?>">
    </div>
    <div class="form-group col-md-6">
        <label for="year_id">Year</label>
        <select name="year_id" id="year_id" class="form-control">
            <option value="">Select Year</option>
            <?php
            foreach ($years as $year) { ?>
                <option <?= $subject['year_id'] == $year['year_id'] ? 'selected' : ''?> value="<?=$year['year_id']?>"><?=$year['name']?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="semester">Semester</label>
        <select name="semester" id="semester" class="form-control">
            <option value="">Select semester</option>
            <?php
            foreach ($semesters as $semester) { ?>
                <option <?php if($semester['name'] == $subject['semester']) { echo 'selected'; }?> value="<?=$semester['name']?>"><?=$semester['name']?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="credit">Credit</label>
        <input type="number" id="credit" class="form-control" name="credit" value="<?=$subject['credit']?>">
    </div>
</div>

