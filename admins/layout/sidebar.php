<?php

$sectionsSql = "SELECT  sections.* FROM sections 
                    LEFT JOIN section_years on sections.id=section_years.section_id GROUP BY sections.id";
$result = mysqli_query($conn, $sectionsSql);
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
                      <a class="collapse-item" href="<?=APP?>/admins/add-student.php?section=<?=$section['name']?>&section_id=<?=$section['id']?>">Add Student</a>
                      <?php
                      $id = $section['id'];
                      $yearsSql = "SELECT section_years.*, years.name FROM section_years 
                        LEFT JOIN years on years.id=section_years.year_id 
                        WHERE section_years.section_id = '$id' GROUP BY years.id";
                      $result = mysqli_query($conn, $yearsSql);
                      $years = $result->fetch_all(MYSQLI_ASSOC);
                      foreach ($years as $year) { ?>
                          <a class="collapse-item" href="<?=APP?>/admins/all-student.php?year_id=<?=$year['year_id']?>&section_id=<?=$id?>"><?= $year['name']?></a>
                      <?php } ?>

                  </div>
              </div>
          </li>
      <?php  } ?>
      <!-- END STUDENTS -->

      <!-- START TEACHERS -->
      <div class="sidebar-heading">
          Teachers
      </div>
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#teacher" aria-expanded="true" aria-controls="collapseProfi">
              <i class="fas fa-fw fa-cog"></i>
              <span>Teachers</span>
          </a>
          <div id="teacher" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item" href="<?=APP?>/admins/add-teacher.php">Add Teacher</a>
                  <a class="collapse-item" href="<?=APP?>/admins/all-teacher.php">Teachers</a>
              </div>
          </div>
      </li>
      <!-- END TEACHERS -->

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
                      <a class="collapse-item" href="<?=APP?>/admins/add-subject.php?section=<?=$section['name']?>&section_id=<?=$section['id']?>">Add Subject</a>
                      <?php
                      $id = $section['id'];
                      $yearsSql = "SELECT section_years.*, years.name FROM section_years 
                    LEFT JOIN years on years.id=section_years.year_id 
                    WHERE section_years.section_id = '$id' GROUP BY years.id";
                      $result = mysqli_query($conn, $yearsSql);
                      $years = $result->fetch_all(MYSQLI_ASSOC);
                      foreach ($years as $year) { ?>
                          <a class="collapse-item" href="<?=APP?>/admins/all-subject.php?year_id=<?=$year['year_id']?>&section_id=<?=$id?>"><?= $year['name']?></a>
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
                          <a class="collapse-item" href="<?=APP?>/admins/add-file.php?section=<?=$section['name']?>&section_id=<?=$section['id']?>">Add File</a>
                          <?php
                          $id = $section['id'];
                          $yearsSql = "SELECT section_years.*, years.name FROM section_years 
                        LEFT JOIN years on years.id=section_years.year_id 
                        WHERE section_years.section_id = '$id' GROUP BY years.id";
                          $result = mysqli_query($conn, $yearsSql);
                          $years = $result->fetch_all(MYSQLI_ASSOC);
                          foreach ($years as $year) { ?>
                              <a class="collapse-item" href="<?=APP?>/admins/all-file.php?year_id=<?=$year['year_id']?>&section_id=<?=$id?>"><?= $year['name']?></a>
                          <?php } ?>

                      </div>
                  </div>
              </li>
          <?php  } ?>
      <!-- END FILES -->

      <!-- START SCHEDULE -->
      <hr class="sidebar-divider">
      <li class="sidebar-heading">
          schedule
      </li>
      <?php

      foreach ($sections as $section) { ?>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#schedule_<?=$section['id']?>" aria-expanded="true" aria-controls="collapse">
                  <i class="fas fa-fw fa-cog"></i>
                  <span><?=$section['name']?></span>
              </a>
              <div id="schedule_<?=$section['id']?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="<?=APP?>/admins/add-schedule.php?section=<?=$section['name']?>&section_id=<?=$section['id']?>">Add Schedule</a>
                      <?php
                      $id = $section['id'];
                      $yearsSql = "SELECT section_years.*, years.name FROM section_years 
                    LEFT JOIN years on years.id=section_years.year_id 
                    WHERE section_years.section_id = '$id' GROUP BY years.id";
                      $result = mysqli_query($conn, $yearsSql);
                      $years = $result->fetch_all(MYSQLI_ASSOC);
                      foreach ($years as $year) { ?>
                          <a class="collapse-item" href="<?=APP?>/admins/all-schedule.php?year_id=<?=$year['year_id']?>&section_id=<?=$id?>"><?= $year['name']?></a>
                      <?php } ?>

                  </div>
              </div>
          </li>
      <?php  } ?>
      <!-- END SCHEDULE -->


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
                          <a class="collapse-item" href="<?=APP?>/admins/add-exam.php?section=<?=$section['name']?>&section_id=<?=$section['id']?>">Add Exam Schedule</a>
                          <?php
                          $id = $section['id'];
                          $yearsSql = "SELECT section_years.*, years.name FROM section_years 
                    LEFT JOIN years on years.id=section_years.year_id 
                    WHERE section_years.section_id = '$id' GROUP BY years.id";
                          $result = mysqli_query($conn, $yearsSql);
                          $years = $result->fetch_all(MYSQLI_ASSOC);
                          foreach ($years as $year) { ?>
                              <a class="collapse-item" href="<?=APP?>/admins/all-exam.php?year_id=<?=$year['year_id']?>&section_id=<?=$id?>"><?= $year['name']?></a>
                          <?php } ?>

                      </div>
                  </div>
              </li>
          <?php  } ?>
          <!-- END EXAM SCHEDULE -->


      <!-- Start Sections -->
      <hr class="sidebar-divider">

      <!-- TEACHER Hea  ding -->
      <div class="sidebar-heading">
          Sections
      </div>

      <!-- Nav Item - TEACHERS -->
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#section" aria-expanded="true" aria-controls="collapse">
              <i class="fas fa-fw fa-cog"></i>
              <span>Sections</span>
          </a>
          <div id="section" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item" href="<?=APP?>/admins/add-section.php">Add Section</a>
                  <a class="collapse-item" href="<?=APP?>/admins/all-section.php">Sections</a>
              </div>
          </div>
      </li>

      <!-- End Sections -->

      <!-- Start years -->
      <hr class="sidebar-divider">

      <!-- TEACHER Heading -->
      <div class="sidebar-heading">
          years
      </div>

      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#year" aria-expanded="true" aria-controls="collapse">
              <i class="fas fa-fw fa-cog"></i>
              <span>Years</span>
          </a>
          <div id="year" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item" href="<?=APP?>/admins/add-year.php">Add Year</a>
                  <a class="collapse-item" href="<?=APP?>/admins/all-year.php">years</a>
              </div>
          </div>
      </li>

      <!-- End years -->

      <!-- Start semesters -->
      <hr class="sidebar-divider">

      <!-- TEACHER Heading -->


      <div class="sidebar-heading">
          Semester
      </div>

      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#semester" aria-expanded="true" aria-controls="collapse">
              <i class="fas fa-fw fa-cog"></i>
              <span>Semester</span>
          </a>
          <div id="semester" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item" href="<?=APP?>/admins/add-semester.php">Add Semester</a>
                  <a class="collapse-item" href="<?=APP?>/admins/all-semester.php">Semester</a>
              </div>
          </div>
      </li>

      <!-- End semesters -->

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