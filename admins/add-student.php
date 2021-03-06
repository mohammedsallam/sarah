<?php
ob_start();
session_start();

if (!isset($_SESSION['sign_type']) || $_SESSION['sign_type'] != 1){
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

$sectionSql = "SELECT * FROM sections";
$result = mysqli_query($conn, $sectionSql);
$sections = $result->fetch_all(MYSQLI_ASSOC);

$yearsSql = "SELECT * FROM years";
$result = mysqli_query($conn, $yearsSql);
$years = $result->fetch_all(MYSQLI_ASSOC);


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
        <h1 class="m-auto h3 mb-0 text-gray-800 text-uppercase">add teacher</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger  d-none error_message text-center"></div>
            <div class="alert alert-success d-none success_message text-center"></div>
        </div>
        <div class="container add-student">
            <form action="<?=APP?>/controllers/students/add.php" method="POST" class="add_teacher_form">
                <input type="hidden" name="section_id" value="<?=@$_GET['section_id']?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" name="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" class="form-control" name="last_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="section">Department</label>
                        <input readonly type="text" id="section" class="form-control bg-white" value="<?=@$_GET['section']?>">
                    </div>
                    <div class="form-group col-md-6">

                        <?php
                        $id = $_GET['section_id'];
                        $name = $_GET['section'];
                        $yearsSql = "SELECT section_years.*, years.name 
                                     AS 'YNAME', sections.name 
                                     FROM section_years
                                     LEFT JOIN years on years.id=section_years.year_id
                                     LEFT JOIN sections on sections.id=section_years.section_id 
                                     WHERE section_years.section_id = '$id' AND sections.name = '$name' 
                                     GROUP BY years.id";
                        $result = mysqli_query($conn, $yearsSql);
                        $years = $result->fetch_all(MYSQLI_ASSOC);
                        ?>
                        <label for="year_id">Year</label>
                        <select name="year_id" id="year_id" class="form-control">
                            <?php
                            foreach ($years as $year) { ?>
                                <option value="<?= $year['year_id']?>"><?= $year['YNAME']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" class="form-control" name="email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control" name="username">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" name="password">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" class="form-control" name="confirm_password">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block add_teacher_button" name="submit">Add</button>
            </form>
        </div>
    </div>

</div>

<?php include('../layout/footer.php');?>

<script>
    $(document).ready(function () {

        $('.add_teacher_button').click(function (e) {
            e.preventDefault();

            let form = $('.add_teacher_form'), error = [];

            $('.add_teacher_form input').each(function () {
                if ($(this).val() === ''){
                    // error.push(true);
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

            if (error.length === 0){
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    dataType: 'json',
                    data: form.serialize(),
                    success: function (data) {
                        if (data.status === 0){
                            $('.error_message').removeClass('d-none').html(data.message);
                            $('.success_message').addClass('d-none').html('');
                        } else {
                            $('.success_message').removeClass('d-none').html(data.message);
                            $('.error_message').addClass('d-none').html('');
                            let buffer = setInterval(function () {
                                $('.success_message').addClass('d-none').html('');
                                clearInterval(buffer)
                            }, 3000);
                            // $('input[type="password"]').each(function () {
                            //     $(this).val('')
                            // })
                        }
                    }
                });
            }


        })
    })
</script>
