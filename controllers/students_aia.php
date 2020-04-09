<?php

ob_start();

require('connection.php');

include('header.php');

include('sidebar.php');

include('topnav.php');

session_start();

?>

<h5>A.I.A.</h5>

<table id="example" class="table stripe row-border order-column text-center" style="width:100%">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">name</th>
      <th scope="col">lname</th>
      <th scope="col">Department</th>
      <th scope="col">year</th>
      <th scope="col">E-mail</th>
      <th scope="col">phone</th>
      <th scope="col">Username</th>
      <th scope="col">password</th>
      <th scope="col">Inreg. Date</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>

  <?php

    while($row = $query2_run->fetch_assoc()): ?>


      <tr>
        <td style="width:5%"><?php echo $row['student_id']; ?></td>
        <td style="width:15%"><?php echo $row['student_name']; ?></td>
        <td style="width:15%"><?php echo $row['student_lname']; ?></td>
        <td style="width:5%"><?php echo $row['student_department']; ?></td>
        <td style="width:5%"><?php echo $row['student_year']; ?></td>
        <td style="width:10%"><?php echo $row['student_email']; ?></td>
        <td style="width:10%"><?php echo $row['student_phone']; ?></td>
        <td style="width:10%"><?php echo $row['student_user']; ?></td>
        <td style="width:5%"><?php echo $row['student_password']; ?></td>
        <td style="width:8%"><?php echo $row['student_inreg_date']; ?></td>
        <td style="width:12%">
          <a href="students_aia.php?edit=<?php echo $row['student_id']; ?>" 
          class="btn-sm btn-warning editbtn" data-toggle="modal" data-target="#editModal">Edit</a>

          <a href="students_aia.php?delete=<?php echo $row['student_id']; ?>" 
          class="btn-sm btn-dyearger">Delete</a>
          <a href="students_info.php?info=<?php echo $row['student_id']; ?>" 
          class="btn-sm btn-info">Info</a>
        </td>
      </tr>

      <?php endwhile; ?>

        
  <!-------------------- Modal Update -------------------->

      <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">update Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <spyear aria-hidden="true">&times;</spyear>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="studenti_aia_1.php" method="POST">
                        <div class="form-row">
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="form-group col-md-6">
                                <label for="inputname">name</label>
                                <input type="text" class="form-control" id="name" name="name_std">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputlname">lname</label>
                                <input type="text" class="form-control" id="lname" name="lname_std">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputSpecialitate">Specialitate</label>
                                <input type="text" class="form-control" name="specialitate" value="A.I.A" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputyear">year</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="year_std">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>
            
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputname">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email_std">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputlname">Nr. phone</label>
                                <input type="phone" class="form-control" id="phone" name="phone_std">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputname">Username</label>
                                <input type="text" class="form-control" id="user" name="user_std">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputpassword">password</label>
                                <input type="password" class="form-control" id="password" name="password_std">
                                <input type="checkbox" onclick="myFunction()">show password
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="updateInfo">update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
</table>


<!-- Delete student -->
<?php
if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
	mysqli_query($conn, "DELETE FROM WHERE student_id = $id");
	$_SESSION['message'] = "S-a sters!"; 
	header('location: students_aia.php');
}

?>



<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="yearonymous"></script>
  
  <script>
  $(document).ready(function() {
    $('#example').DataTable({
      "scrollX": true,
      scrollCollapse: true,
      fixedColumns:   true,
      select:         true,
      }

     });


});
</script>

<script>

function myFunction() {
  var x = document.gephoneementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

</script>

<script>

  $(document).ready(function(){
    $('.editbtn').on('click', function(){

      $('#editModal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
          return $(this).text();
        }).get();

        console.log(data);

        $('#update_id').val(data[0]);
        $('#name').val(data[1]);
        $('#lname').val(data[2]);
        $('#inlineFormCustomSelect').val(data[4]);
        $('#email').val(data[5]);
        $('#phone').val(data[6]);
        $('#user').val(data[7]);
        $('#password').val(data[8]);
        

    });

  });

</script>

<?php

include('footer.php');

?>