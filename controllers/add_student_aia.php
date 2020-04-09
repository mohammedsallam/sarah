<?php
ob_start();

require_once 'connection.php';

include 'layout/header.php';

include('layout/sidebar.php');

include('layout/topnav.php');

session_start();

?>




<!-- Begin Page Content -->
<div class="container-fluid">
      
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add student</h1>
  </div>

  <!-- Content Row -->
  <div class="row">

    <div class="container add-student">

      <h4 class="text-center titlu-categorie">A.I.A.</h4>

        <form action="" method="POST">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputName">Name</label>
              <input type="text" class="form-control" name="name_std">
            </div>
            <div class="form-group col-md-6">
              <label for="inputLname">Last Name</label>
              <input type="text" class="form-control" name="lname_std">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
            <label for="inputdepartment">department</label>

            <input type="text" class="form-control" id="department" name="department" value="A.I.A." readonly>

            </div>
            <div class="form-group col-md-6">
              <label for="inputYear">Year</label>

              <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="year_std">

            

              
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail">E-mail</label>
              <input type="email" class="form-control" name="email_std">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPhone">Phone</label>
              <input type="tel" class="form-control" name="Phone_std">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputUser">Username</label>
              <input type="text" class="form-control" name="user_std">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword">password</label>
              <input type="password" id="password" class="form-control" name="password_std">
              <input type="checkbox" onclick="myFunction()">show password
            </div>
          </div>
          
          <button type="submit" class="btn btn-primary" name="submit">Add</button>
        </form> 



        <?php if (isset($_SESSION['mesaj'])): ?>

          <div class="mesaj">
            <?php

              echo $_SESSION['mesaj'];
              unset ($_SESSION['mesaj']);

            ?>
          </div>
        <?php endif ?>

        <?php

          //Add student function
                      
          
              $_SESSION['mesaj'] = "The student was added successfully";
          
            ?>

          </div>
      </div>
      

<script>

function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

</script>


<?php

include('layout/footer.php');

?>