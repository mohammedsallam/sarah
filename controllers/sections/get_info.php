<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once '../../connection.php';

   $id = (int) $_GET['id'];


    $sql = "SELECT sections.*, section_years.* FROM sections
            LEFT JOIN section_years
            ON sections.id=section_years.section_id
            WHERE sections.id = '$id'";
   $query = mysqli_query($conn, $sql);
   $section = null;
   $rows = $query->num_rows;
   if ($rows == 0){
       $section = $query->fetch_assoc();
   } else {
       $section = $query->fetch_all(MYSQLI_ASSOC);
   }


    $yearsSql = "SELECT * FROM years";
    $result = mysqli_query($conn, $yearsSql);
    $years = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<input type="hidden" name="id" value="<?=$id?>">
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="name">Name</label>
        <input type="text" id="name" class="form-control" name="name" value="<?=$section[0]['name']?>">
    </div>
    <div class="form-group col-md-12">
        <label for="fees">Fees</label>
        <input type="number" id="fees" min="0" class="form-control" name="fees" value="<?=$section[0]['fees']?>">
    </div>

    <?php

    if ($rows > 1){
        foreach ($years as $key => $year) { ?>
            <div class="form-group col-md-2">
                <label style="cursor: pointer" for="year_<?=$year['id']?>" class="text-capitalize form-label-group"><?= $year['name']?></label>
                <input <?php if (in_array(@$section[$key]['year_id'], $year)) { echo 'checked'; }?> class="form-check-inline" style="width: 16px; height: 16px" type="checkbox" id="year_<?=$year['id']?>" name="year_id[]" value="<?= $year['id'] ?>">
            </div>
        <?php }
    } else {
        foreach ($years as $key => $year){ ?>
            <label style="cursor: pointer" for="year_<?=$year['id']?>" class="text-capitalize form-label-group"><?= $year['name']?></label>
            <input class="form-check-inline" style="width: 16px; height: 16px" type="checkbox" id="year_<?=$year['id']?>" name="year_id[]" value="<?= $year['id'] ?>">
        <?php }
    }?>
</div>
