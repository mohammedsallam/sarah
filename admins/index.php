<?php
ob_start();
session_start();
if (!isset($_SESSION['sign_type']) || $_SESSION['sign_type'] != 1){
    header("location: ../login.php");
    exit();
}
require('../connection.php');


$id = $_SESSION['id'];
$sql = "SELECT * FROM admins WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$admin = $result->fetch_array(MYSQLI_ASSOC);

include('../layout/header.php');

include('layout/sidebar.php');

include('layout/topnav.php');

$sql = "SELECT * FROM teachers";
$result = mysqli_query($conn, $sql);
$teacherCount = $result->num_rows;

$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);
$studentCount = $result->num_rows;

$sql = "SELECT * FROM schedules";
$result = mysqli_query($conn, $sql);
$scheduleCount = $result->num_rows;

$sql = "SELECT * FROM subjects";
$result = mysqli_query($conn, $sql);
$subjectCount = $result->num_rows;

$sql = "SELECT * FROM exams";
$result = mysqli_query($conn, $sql);
$examCount = $result->num_rows;

$sql = "SELECT * FROM courses";
$result = mysqli_query($conn, $sql);
$courseCount = $result->num_rows;


?>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none error_message text-center"></div>
                <div class="alert alert-success d-none success_message text-center"></div>
                <form class="password_form" action="<?=APP?>/controllers/profile.php" method="post">
                    <input type="hidden" name="id" value="<?=@$admin['id']?>">
                    <input type="hidden" name="type" value="1">
                    <div class="form-group">
                        <label for="name">name</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?=@$admin['name']?>">
                    </div>
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
        <h1 class="h3 mb-0 text-gray-800">Home</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Teacher Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Teachers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$teacherCount?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$studentCount?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total schedules Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total schedules</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$scheduleCount?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total subjects Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total subjects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$subjectCount?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total exams Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total exams</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$examCount?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total courses Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total courses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$courseCount?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include('../layout/footer.php');?>

<script>
    $(document).ready(function () {
        $('.modal .change_password').click(function (e) {
            e.preventDefault();

            let form = $('.password_form');

            $('.password_form input[type="text"]').each(function () {
                if ($(this).val() === ''){
                    $(this).css({
                        border: '1px solid red'
                    });

                    $(this).focus(function () {
                        $(this).css({
                            border: '1px solid #ced4da'
                        });
                    });

                }

            });

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                dataType: 'json',
                data: form.serialize(),
                success: function (data) {
                    if (data.status === 0){
                        $('.modal .error_message').removeClass('d-none').html(data.message);
                        $('.modal .success_message').addClass('d-none').html('');
                    } else {
                        $('.modal .success_message').removeClass('d-none').html(data.message);
                        $('.modal .error_message').addClass('d-none').html('');
                        let buffer = setInterval(function () {
                            $('.modal .success_message').addClass('d-none').html('');
                            window.location.reload();
                            clearInterval(buffer)
                        }, 1000);
                        $('input[type="password"]').each(function () {
                            $(this).val('')
                        })

                    }
                }
            });
        })
    })
</script>
