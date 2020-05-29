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

$teacherSql = "SELECT * FROM teachers";
$result = mysqli_query($conn, $teacherSql);
$teacherCount = $result->num_rows;

$studentSql = "SELECT * FROM students";
$result = mysqli_query($conn, $studentSql);
$studentCount = $result->num_rows;



?>


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
    </div>

</div>

<?php include('../layout/footer.php');?>

<script>
    $(document).ready(function () {
        $('.modal .change_password').click(function (e) {
            e.preventDefault();

            let form = $('.password_form');

            $('input[type="password"]').each(function () {
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
                            clearInterval(buffer)
                        }, 3000);
                        $('input[type="password"]').each(function () {
                            $(this).val('')
                        })
                    }
                }
            });
        })
    })
</script>
