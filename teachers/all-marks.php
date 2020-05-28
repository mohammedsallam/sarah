<?php
ob_start();
session_start();

if (!isset($_SESSION['sign_type']) || $_SESSION['sign_type'] != 2){
    header("location: ../login.php");
    exit();
}

require('../connection.php');

include('../layout/header.php');

include('layout/sidebar.php');

include('layout/topnav.php');

$section_id = @$_GET['section_id'];
$subject_id = @$_GET['subject_id'];
$year_id = @$_GET['year_id'];
$subject_name = @$_GET['subject_name'];
$teacher_id = $_SESSION['id'];

$sql = "SELECT students.name AS 'STD_NAME', 
        students.id AS 'STD_ID', 
        students.last_name AS 'STD_LAST_NAME',
        marks.mark, marks.session, subjects.name AS 'SUB_NAME'
        FROM students INNER JOIN marks ON students.id=marks.student_id
        INNER JOIN subjects ON subjects.id=marks.subject_id";
//WHERE students.year_id !='$year_id' OR students.section_id !='$section_id'
$result = mysqli_query($conn, $sql);
$students = $result->fetch_all(MYSQLI_ASSOC);


$sql = "SELECT * FROM semesters";
$result = mysqli_query($conn, $sql);
$semesters = $result->fetch_all(MYSQLI_ASSOC);


?>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none error_message text-center"></div>
                <div class="alert alert-success d-none success_message text-center"></div>
                <form class="password_form" action="<?=APP?>/controllers/profile.php" method="post">
                    <input type="hidden" name="id" value="<?=$_SESSION['id']?>">
                    <input type="hidden" name="type" value="3">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-block change_password" href="login.html">Change password</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="m-auto h3 mb-0 text-gray-800 text-uppercase">All students marks</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger d-none error_message text-center"></div>
            <div class="alert alert-success d-none success_message text-center"></div>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered years_table">
                <thead>
                <tr class="bg-dark text-light text-center">
                    <th>ID</th>
                    <th>Subject Name</th>
                    <th>Student Name</th>
                    <th>Mark</th>
                    <th>Session</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($students as $student) { ?>
                    <tr class="text-center">
                        <td><?= $student['STD_ID']?></td>
                        <td><?= $student['SUB_NAME']?></td>
                        <td><?= $student['STD_NAME'] . ' ' . $student['STD_LAST_NAME']?></td>
                        <td>
                            <input type="text" class="form-control bg-white" readonly value="<?=@$student['mark']?>">
                        </td>
                        <td>
                            <input type="text" value="<?=$student['session']?>" readonly class="form-control bg-white">
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include('../layout/footer.php');?>
<script>
    $(document).ready(function () {
        $('table').dataTable();
    })
</script>
