<?php
ob_start();
session_start();

if (!isset($_SESSION['sign_type']) || $_SESSION['sign_type'] != 3){
    header("location: ../login.php");
    exit();
}

require('../connection.php');

include('../layout/header.php');

include('layout/sidebar.php');

include('layout/topnav.php');

$student_id = $_SESSION['id'];

$sql = "SELECT fees.*, years.name FROM fees 
        LEFT JOIN years ON years.id=fees.year_id
        WHERE fees.student_id = '$student_id'";
$result = mysqli_query($conn, $sql);
$fees = $result->fetch_all(MYSQLI_ASSOC);


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
        <h1 class="m-auto h3 mb-0 text-gray-800 text-uppercase">All your marks</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger d-none error_message text-center"></div>
            <div class="alert alert-success d-none success_message text-center"></div>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered students_table col-md-12">
                <thead>
                <tr class="bg-dark text-light">
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Year</th>
                    <th>Fees type</th>
                    <th>Ticket Nr</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($fees as $fee) { ?>
                    <tr>
                        <td><?= $fee['id']?></td>
                        <td><?= $fee['fees']?></td>
                        <td><?=$fee['name']?></td>
                        <td><?= $fee['fees_type']?></td>
                        <td><?= $fee['ticket']?></td>
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
