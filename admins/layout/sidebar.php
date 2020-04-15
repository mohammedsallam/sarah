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

        <!-- Start Teacher -->
        <hr class="sidebar-divider">
  
        <!-- TEACHER Heading -->
        <div class="sidebar-heading">
        Teachers
        </div>
  
        <!-- Nav Item - TEACHERS -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProfi" aria-expanded="true" aria-controls="collapseProfi">
            <i class="fas fa-fw fa-cog"></i>
            <span>Teachers</span>
          </a>
          <div id="collapseProfi" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item" href="<?=APP?>/admins/add-teacher.php">Add Teacher</a>
              <a class="collapse-item" href="<?=APP?>/admins/all-teacher.php">Teachers</a>
            </div>
          </div>
        </li>
          <!-- End Teacher -->

      <!-- Start Students -->
      <hr class="sidebar-divider">

      <!-- TEACHER Heading -->
      <div class="sidebar-heading">
          Students
      </div>

      <!-- Nav Item - TEACHERS -->
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#student" aria-expanded="true" aria-controls="collapseProfi">
              <i class="fas fa-fw fa-cog"></i>
              <span>Students</span>
          </a>
          <div id="student" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item" href="<?=APP?>/admins/add-student.php">Add Student</a>
                  <a class="collapse-item" href="<?=APP?>/admins/all-student.php">Students</a>
              </div>
          </div>
      </li>

      <!-- End student -->

      <!-- Start Sections -->
      <hr class="sidebar-divider">

      <!-- TEACHER Heading -->
      <div class="sidebar-heading">
          Sections
      </div>

      <!-- Nav Item - TEACHERS -->
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#section" aria-expanded="true" aria-controls="collapseProfi">
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
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#year" aria-expanded="true" aria-controls="collapseProfi">
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

          <!-- Start years -->
          <hr class="sidebar-divider">

          <!-- TEACHER Heading -->
          <div class="sidebar-heading">
              Semester
          </div>

          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#semester" aria-expanded="true" aria-controls="collapseProfi">
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

          <!-- End years -->

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