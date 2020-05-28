<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

    $teacher_id = filter_var($_GET['teacher_id'], FILTER_SANITIZE_NUMBER_INT);
    $sql = "SELECT teachers.year_id FROM teachers WHERE id = '$teacher_id'";
    $result = mysqli_query($conn, $sql);
    $teacher = $result->fetch_array(MYSQLI_ASSOC);

    $year_id = $teacher['year_id'];

    $sql = "SELECT * FROM years WHERE id = '$year_id'";
    $result = mysqli_query($conn, $sql);
    $years = $result->fetch_all(MYSQLI_ASSOC);

    ?>

    <option value="">Select Year</option>
    <?php foreach ($years as $year) { ?>
        <option value="<?=$year['id']?>"><?=$year['name']?></option>
     <?php } ?>

<?php } else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}