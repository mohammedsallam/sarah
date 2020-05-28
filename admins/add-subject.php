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

$section_id = @$_GET['section_id'];

$teacherSql = "SELECT * FROM teachers";
$result = mysqli_query($conn, $teacherSql);
$teachers = $result->fetch_all(MYSQLI_ASSOC);
$teacherCount = $result->num_rows;

$studentSql = "SELECT * FROM students";
$result = mysqli_query($conn, $studentSql);
$studentCount = $result->num_rows;

$sectionSql = "SELECT * FROM sections";
$result = mysqli_query($conn, $sectionSql);
$sections = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT section_years.*, years.name FROM section_years 
            LEFT JOIN years on years.id=section_years.year_id 
            WHERE section_years.section_id = '$section_id' GROUP BY years.id";
$result = mysqli_query($conn, $sql);
$years = $result->fetch_all(MYSQLI_ASSOC);

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
        <h1 class="m-auto h3 mb-0 text-gray-800 text-uppercase">add subject</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger  d-none error_message text-center"></div>
            <div class="alert alert-success d-none success_message text-center"></div>
        </div>
        <div class="container add-student">
            <form action="<?=APP?>/controllers/subjects/add.php" method="POST" class="add_subject_form" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Subject Name</label>
                        <input type="text" id="name" class="form-control" name="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="teacher_id">Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="form-control teacher_id">
                            <option value="">Select teacher</option>
                            <?php
                            foreach ($teachers as $teacher) { ?>
                                <option value="<?= $teacher['id']?>"><?= $teacher['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Department</label>
                        <input readonly type="text" id="name" class="form-control bg-white" value="<?=$_GET['section']?>">
                        <input type="hidden" class="section_id" name="section_id" value="<?=$section_id?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="year_id">Year</label>
                        <select name="year_id" id="year_id" class="form-control year_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($years as $year) { ?>
                                <option value="<?=$year['year_id']?>"><?=$year['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="semester">Semester</label>
                        <select name="semester" id="semester" class="form-control">
                            <option value="">Select semester</option>
                            <?php
                            foreach ($semesters as $semester) { ?>
                                <option value="<?=$semester['name']?>"><?=$semester['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="credit">Credit</label>
                        <input type="number" id="credit" class="form-control" name="credit">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block add_subject_button" name="submit">Add</button>
            </form>

        </div>
    </div>

</div>

<?php include('../layout/footer.php');?>



<script>
    $(document).ready(function () {

        $('.add_subject_button').click(function (e) {
            e.preventDefault();

            let form = $('.add_subject_form'), formData = new FormData(form[0]),  error = [];

            $('.add_subject_form input, select').each(function () {
                if ($(this).val() === ''){
                    error.push(true);
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
                    crossDomain: true,
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: formData,
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


        });

        // $(document).on('change', '.teacher_id', function(){
        //     if ($(this).val() !== ''){
        //         $.ajax({
        //             url: '../controllers/subjects/get_teacher_info.php',
        //             type: 'GET',
        //             dataType: 'html',
        //             data: {teacher_id: $(this).val()},
        //             success: function (data) {
        //                 $('.year_id').html(data)
        //             }
        //         })
        //     } else {
        //         $('.year_id').html('<option>Select Section</option>')
        //     }
        // })
    })
</script>
