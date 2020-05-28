<?php
$id = $_SESSION['id'];
$sql = "SELECT * FROM teachers WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$teacher = $result->fetch_array(MYSQLI_ASSOC);

$section = $teacher['section'];
$sql = "SELECT  sections.* FROM sections
                    LEFT JOIN section_years on sections.id=section_years.section_id WHERE sections.name = '$section' GROUP BY sections.id ";
$result = mysqli_query($conn, $sql);
$sections = $result->fetch_all(MYSQLI_ASSOC);

?>

<!-- Page Wrapper -->
<div id="wrapper">
      
      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
          <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-university"></i>
          </div>
          <div class="sidebar-brand-text mx-3"></div>
        </a>

      <!-- START STUDENTS -->
      <hr class="sidebar-divider">
      <li class="sidebar-heading">
          Students
      </li>
      <?php

      foreach ($sections as $section) { ?>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#student_<?=$section['id']?>" aria-expanded="true" aria-controls="collapseProfi">
                  <i class="fas fa-fw fa-cog"></i>
                  <span><?=$section['name']?></span>
              </a>
              <div id="student_<?=$section['id']?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <?php
                      $id = $section['id'];
                      $yearsSql = "SELECT section_years.*, years.name FROM section_years 
                        LEFT JOIN years on years.id=section_years.year_id 
                        WHERE section_years.section_id = '$id' GROUP BY years.id";
                      $result = mysqli_query($conn, $yearsSql);
                      $years = $result->fetch_all(MYSQLI_ASSOC);
                      foreach ($years as $year) { ?>
                          <a class="collapse-item" href="<?=APP?>/teachers/all-student.php?year_id=<?=$year['year_id']?>&section_id=<?=$id?>"><?= $year['name']?></a>
                      <?php } ?>

                  </div>
              </div>
          </li>
      <?php  } ?>
      <!-- END STUDENTS -->


      <!-- START SUBJECTS -->
      <hr class="sidebar-divider">
      <li class="sidebar-heading">
          Subjects
      </li>
      <?php

      foreach ($sections as $section) { ?>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#subject_<?=$section['id']?>" aria-expanded="true" aria-controls="collapseProfi">
                  <i class="fas fa-fw fa-cog"></i>
                  <span><?=$section['name']?></span>
              </a>
              <div id="subject_<?=$section['id']?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="<?=APP?>/teachers/add-subject.php?section=<?=$section['name']?>&section_id=<?=$section['id']?>">Add Subject</a>
                      <?php
                      $id = $section['id'];
                      $yearsSql = "SELECT section_years.*, years.name FROM section_years 
                    LEFT JOIN years on years.id=section_years.year_id 
                    WHERE section_years.section_id = '$id' GROUP BY years.id";
                      $result = mysqli_query($conn, $yearsSql);
                      $years = $result->fetch_all(MYSQLI_ASSOC);
                      foreach ($years as $year) { ?>
                          <a class="collapse-item" href="<?=APP?>/teachers/all-subject.php?year_id=<?=$year['year_id']?>&section_id=<?=$id?>"><?= $year['name']?></a>
                      <?php } ?>

                  </div>
              </div>
          </li>
      <?php  } ?>
      <!-- END SUBJECTS -->


      <!-- START FILES -->
          <hr class="sidebar-divider">
          <li class="sidebar-heading">
              files
          </li>
          <?php

          foreach ($sections as $section) { ?>
              <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#file_<?=$section['id']?>" aria-expanded="true" aria-controls="collapse">
                      <i class="fas fa-fw fa-cog"></i>
                      <span><?=$section['name']?></span>
                  </a>
                  <div id="file_<?=$section['id']?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                          <a class="collapse-item" href="<?=APP?>/teachers/add-file.php?section=<?=$section['name']?>&section_id=<?=$section['id']?>">Add File</a>
                          <?php
                          $id = $section['id'];
                          $yearsSql = "SELECT section_years.*, years.name FROM section_years 
                        LEFT JOIN years on years.id=section_years.year_id 
                        WHERE section_years.section_id = '$id' GROUP BY years.id";
                          $result = mysqli_query($conn, $yearsSql);
                          $years = $result->fetch_all(MYSQLI_ASSOC);
                          foreach ($years as $year) { ?>
                              <a class="collapse-item" href="<?=APP?>/teachers/all-file.php?year_id=<?=$year['year_id']?>&section_id=<?=$id?>"><?= $year['name']?></a>
                          <?php } ?>

                      </div>
                  </div>
              </li>
          <?php  } ?>
      <!-- END FILES -->



          <!-- START EXAM SCHEDULE -->
          <hr class="sidebar-divider">
          <li class="sidebar-heading">
              exam schedule
          </li>
          <?php

          foreach ($sections as $section) { ?>
              <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#exam_schedule_<?=$section['id']?>" aria-expanded="true" aria-controls="collapse">
                      <i class="fas fa-fw fa-cog"></i>
                      <span><?=$section['name']?></span>
                  </a>
                  <div id="exam_schedule_<?=$section['id']?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                          <a class="collapse-item" href="<?=APP?>/teachers/add-exam-schedule.php?section=<?=$section['name']?>&section_id=<?=$section['id']?>">Add Exam Schedule</a>
                          <?php
                          $id = $section['id'];
                          $yearsSql = "SELECT section_years.*, years.name FROM section_years 
                    LEFT JOIN years on years.id=section_years.year_id 
                    WHERE section_years.section_id = '$id' GROUP BY years.id";
                          $result = mysqli_query($conn, $yearsSql);
                          $years = $result->fetch_all(MYSQLI_ASSOC);
                          foreach ($years as $year) { ?>
                              <a class="collapse-item" href="<?=APP?>/teachers/all-schedule.php?year_id=<?=$year['year_id']?>&section_id=<?=$id?>"><?= $year['name']?></a>
                          <?php } ?>

                      </div>
                  </div>
              </li>
          <?php  } ?>
          <!-- END EXAM SCHEDULE -->



        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
  
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
  
      </ul>
      <!-- End of Sidebar -->
  
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
  
        <!-- Main Content -->
        <div id="content">