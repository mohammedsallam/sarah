<?php

$sql = "SELECT sections.* FROM sections 
                    LEFT JOIN section_years on sections.id=section_years.section_id 
                    GROUP BY sections.id";
$result = mysqli_query($conn, $sql);
$sections = $result->fetch_all(MYSQLI_ASSOC);

$teacher_id = $_SESSION['id'];
$sql = "SELECT teachers.*, subjects.*, subjects.id AS 'SUBID',subjects.name AS 'SUBNAME' FROM subjects 
        LEFT JOIN teachers on teachers.id=subjects.teacher_id WHERE teachers.id='$teacher_id'";
$result = mysqli_query($conn, $sql);
$subjects = $result->fetch_all(MYSQLI_ASSOC);

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

        <!-- START MARKS -->
        <hr class="sidebar-divider">
        <li class="sidebar-heading">
            Marks
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#marks" aria-expanded="true" aria-controls="collapseProfi">
                <i class="fas fa-fw fa-cog"></i>
                <span>Marks</span>
            </a>
            <div id="marks" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?=APP?>/students/all-marks.php">All marks</a>
                </div>
            </div>
        </li>
        <!-- END MARKS -->

        <!-- START FEES -->
        <hr class="sidebar-divider">
        <li class="sidebar-heading">
            Fees
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#fees" aria-expanded="true" aria-controls="collapseProfi">
                <i class="fas fa-fw fa-cog"></i>
                <span>Fees</span>
            </a>
            <div id="fees" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?=APP?>/students/all-fees.php">All Fees</a>
                </div>
            </div>
        </li>
        <!-- END FEES -->

        <!-- START FILES -->
        <hr class="sidebar-divider">
        <li class="sidebar-heading">
            Files
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#files" aria-expanded="true" aria-controls="collapseProfi">
                <i class="fas fa-fw fa-cog"></i>
                <span>Files</span>
            </a>
            <div id="files" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?=APP?>/students/all-file.php">Subjects</a>
                    <a class="collapse-item" href="<?=APP?>/students/all-exam.php">Exams</a>
                    <a class="collapse-item" href="<?=APP?>/students/all-schedule.php">Schedules</a>
                    <a class="collapse-item" href="<?=APP?>/students/all-course.php">Materials</a>

                </div>
            </div>
        </li>
        <!-- END FILES -->


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