<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

   $id = (int) $_GET['id'];

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

    $year_id = $subject['YID'];
    $yearsSql = "SELECT * FROM years WHERE id ='$year_id'";
    $result = mysqli_query($conn, $yearsSql);
    $year = $result->fetch_array(MYSQLI_ASSOC);

    $teacher_id = $subject['teacher_id'];
    $teacherSql = "SELECT * FROM teachers WHERE id = '$teacher_id'";
    $result = mysqli_query($conn, $teacherSql);
    $teacher = $result->fetch_array(MYSQLI_ASSOC);

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
        <input type="text" class="form-control bg-white" readonly  value="<?=$teacher['name']?>">
        <input type="hidden" name="teacher_id" value="<?=$teacher['id']?>">
    </div>
    <div class="form-group col-md-6">
        <label for="section_id">Department</label>
        <input type="text" class="form-control bg-white" readonly  value="<?=$subject['SNAME']?>">
        <input type="hidden" name="section_id" value="<?=$subject['SID']?>">
    </div>
    <div class="form-group col-md-6">
        <label for="year_id">Year</label>
        <input type="text" class="form-control bg-white" readonly  value="<?=$year['name']?>">
        <input type="hidden" name="year_id" value="<?=$year['id']?>">
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

