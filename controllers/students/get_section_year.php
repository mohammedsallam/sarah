<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

    $section_id = filter_var($_GET['section_id'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT section_years.*, years.name FROM section_years 
            LEFT JOIN years on years.id=section_years.year_id 
            WHERE section_years.section_id = '$section_id' GROUP BY years.id";
    $result = mysqli_query($conn, $sql);
    $years = $result->fetch_all(MYSQLI_ASSOC); ?>

    <option value="">Select Year</option>
    <?php foreach ($years as $year) { ?>
        <option value="<?=$year['year_id']?>"><?=$year['name']?></option>
     <?php } ?>

<?php } else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}