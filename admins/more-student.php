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

//$teacherSql = "SELECT * FROM teachers";
//$result = mysqli_query($conn, $teacherSql);
//$teacherCount = $result->num_rows;
$year_id = @$_GET['year_id'];
$student_id = @$_GET['student_id'];
$section_id = @$_GET['section_id'];

$sql = "SELECT teachers.name AS 'TEACHER', subjects.* FROM subjects 
            LEFT JOIN teachers ON teachers.id=subjects.teacher_id 
            WHERE subjects.year_id = '$year_id' AND subjects.section_id = '$section_id'";
$result = mysqli_query($conn, $sql);
$subjects = $result->fetch_all(MYSQLI_ASSOC);
$teacherCount = $result->num_rows;


$sql = "SELECT * FROM years WHERE id = '$year_id'";
$result = mysqli_query($conn, $sql);
$years = $result->fetch_assoc();

$sql = "SELECT subjects.name AS 'SUBNAME' , 
                 subjects.id AS 'SUBID', years.name AS 'YEARNAME', years.id AS 'YID', marks.*
                  FROM marks
                 LEFT JOIN subjects ON subjects.id=marks.subject_id
                 LEFT JOIN years ON years.id=marks.year_id
                WHERE marks.year_id = '$year_id' AND marks.student_id = '$student_id' AND marks.section_id = '$section_id' ";
$result = mysqli_query($conn, $sql);
$marks = $result->fetch_all(MYSQLI_BOTH);
$teacherCount = $result->num_rows;

$sql = "SELECT * FROM fees";
$result = mysqli_query($conn, $sql);
$fees = $result->fetch_all(MYSQLI_BOTH);


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
        <h1 class="m-auto h3 mb-0 text-gray-800 text-uppercase">student information</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger d-none error_message text-center"></div>
            <div class="alert alert-success d-none success_message text-center"></div>
        </div>


        <nav class="col-md-12">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#marks" role="tab" aria-controls="nav-home" aria-selected="true">Marks</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#fees" role="tab" aria-controls="nav-profile" aria-selected="false">Fees</a>
            </div>
        </nav>

        <div class="tab-content col-md-12 mt-5" id="nav-tabContent">
            <!-- Start marks -->
            <div class="tab-pane fade show active" id="marks" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="container add-student">
                    <form action="<?=APP?>/controllers/students/marks.php" method="POST" class="add_marks_form mb-5">
                        <input type="hidden" name="section_id" value="<?=@$_GET['section_id']?>">
                        <input type="hidden" name="year_id" value="<?=@$_GET['year_id']?>">
                        <input type="hidden" name="student_id" value="<?=@$_GET['student_id']?>">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="name">Year</label>
                                <input readonly type="text" id="name" value="<?=$years['name']?>" class="form-control bg-white">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="subject_id">Subject</label>
                                <select name="subject_id" id="subject_id" class="form-control">
                                    <?php
                                    foreach ($subjects as $subject) { ?>
                                        <option value="<?= $subject['id']?>"><?= $subject['name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="mark">Mark</label>
                                <input type="number" min="0" id="mark" class="form-control" name="mark">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="session">Session</label>
                                <select name="session" id="session" class="form-control">
                                    <option value="semester">Semester</option>
                                    <option value="re_exam">Re-Exam</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block add_marks_button" name="submit">Add</button>

                    </form>
                    <table class="table table-bordered students_table col-md-12">
                        <thead>
                        <tr class="bg-dark text-light">
                            <th>ID</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Year</th>
                            <th>Mark</th>
                            <th>Session</th>
                            <th>Control</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($marks as $mark) {
                            $id = $mark['SUBID'];
                            $sql = "SELECT teachers.name AS 'TEACHER' FROM subjects LEFT JOIN teachers ON teachers.id=subjects.teacher_id WHERE subjects.id = '$id'";
                            $result = mysqli_query($conn, $sql);
                            $teacher = $result->fetch_assoc();
                            ?>
                            <tr>
                                <td><?= $mark['id']?></td>
                                <td><?= $mark['SUBNAME']?></td>
                                <td><?= $teacher['TEACHER']?></td>
                                <td><?= $mark['YEARNAME']?></td>
                                <td><?= $mark['mark']?></td>
                                <td><?= $mark['session']?></td>
                                <td>
                                    <a data-toggle="modal" data-target="#edit_marks_modal" href="#" data-href="<?=APP?>/controllers/students/get_marks_info.php?student_id=<?=$student_id?>&year_id=<?=$year_id?>&section_id=<?=$section_id?>&subject_id=<?=$id?>" class="btn btn-info btn-sm edit_marks_link"><i class="fa fa-pen-alt"></i></a>
                                    <a data-toggle="modal" data-target="#delete_modal" href="#" data-href="<?=APP?>/controllers/students/delete-mark.php?id=<?=$mark['id']?>" class="btn btn-danger btn-sm delete_link"><i class="fa fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End marks -->

            <!-- Start fees -->
            <div class="tab-pane fade" id="fees" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="container add-student">
                    <form action="<?=APP?>/controllers/students/fees.php" method="POST" class="add_fees_form mb-5">
                        <input type="hidden" name="section_id" value="<?=@$_GET['section_id']?>">
                        <input type="hidden" name="year_id" value="<?=@$_GET['year_id']?>">
                        <input type="hidden" name="student_id" value="<?=@$_GET['student_id']?>">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="name">Year</label>
                                <input readonly type="text" id="name" value="<?=$years['name']?>" class="form-control bg-white">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fees">Amount</label>
                                <input name="fees" id="fees" type="number" min="0" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="type">Fee type</label>
                                <select name="fees_type" id="type" class="form-control">
                                    <option value="">select</option>
                                    <option value="Integral fee paid">Integral fee paid</option>
                                    <option value="Rate 1">Rate 1</option>
                                    <option value="Rate 2">Rate 2</option>
                                    <option value="Rate 3">Rate 3</option>
                                    <option value="Rate 4">Rate 4</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="ticket">Ticket Nr</label>
                                <input name="ticket" id="ticket" type="number" min="0" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block add_fees_button" name="submit">Add</button>

                    </form>
                    <table class="table table-bordered students_table col-md-12">
                        <thead>
                        <tr class="bg-dark text-light">
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Year</th>
                            <th>Fees type</th>
                            <th>Ticket Nr</th>
                            <th>Control</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($fees as $fee) { ?>
                            <tr>
                                <td><?= $fee['id']?></td>
                                <td><?= $fee['fees']?></td>
                                <td><?=$years['name']?></td>
                                <td><?= $fee['fees_type']?></td>
                                <td><?= $fee['ticket']?></td>
                                <td>
                                    <a data-toggle="modal" data-target="#edit_fees_modal" href="#" data-href="<?=APP?>/controllers/students/get_fees_info.php?student_id=<?=$student_id?>&year_id=<?=$year_id?>&fees_id=<?=$fee['id']?>" class="btn btn-info btn-sm edit_fees_link"><i class="fa fa-pen-alt"></i></a>
                                    <a data-toggle="modal" data-target="#delete_modal" href="#" data-href="<?=APP?>/controllers/students/delete-fee.php?id=<?=$fee['id']?>" class="btn btn-danger btn-sm delete_link"><i class="fa fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End fees -->

        </div>

    </div>

</div>

<!-- Edit marks modal -->
<div class="modal marks_modal fade" id="edit_marks_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit marks</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none error_message text-center"></div>
                <div class="alert alert-success d-none success_message text-center"></div>
                <form class="marks_form" action="<?=APP?>/controllers/students/marks.php" method="post"></form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success btn-block do_edit_marks_link" href="#">Edit</a>
            </div>
        </div>
    </div>
</div>

<!-- Edit marks modal -->
<div class="modal fees_modal fade" id="edit_fees_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Fees</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none error_message text-center"></div>
                <div class="alert alert-success d-none success_message text-center"></div>
                <form class="fees_form" action="<?=APP?>/controllers/students/fees.php" method="post"></form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success btn-block do_edit_fees_link" href="#">Edit</a>
            </div>
        </div>
    </div>
</div>

<!-- Delete marks modal -->
<div class="modal fade delete_modal" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h3><i class="fa fa-exclamation-triangle text-danger"></i> <span>Are you sure?</span></h3>
            </div>
            <div class="modal-footer">
                <a href="javascript:void" class="btn btn-danger btn-block">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php include('../layout/footer.php');?>

<script>
    $(document).ready(function () {

        $('table').dataTable();

        // Marks section
        $('.add_marks_button').click(function (e) {
            e.preventDefault();

            let form = $('.add_marks_form'), error = [];

            $('.add_marks_form input').each(function () {
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
                                window.location.reload()
                                clearInterval(buffer)
                            }, 1000);
                            // $('input[type="password"]').each(function () {
                            //     $(this).val('')
                            // })
                        }
                    }
                });
            }


        });

        $('.edit_marks_link').click(function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).data('href'),
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                    $('.marks_modal .marks_form').html(data);
                }
            });

        });

        $('.do_edit_marks_link').click(function (e) {
            e.preventDefault();
            let form = $('.marks_form');

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                dataType: 'json',
                data: form.serialize(),
                success:function (data) {
                    if (data.status === 0){
                        $('.marks_modal .error_message').removeClass('d-none').html(data.message);
                        $('.marks_modal .success_message').addClass('d-none').html('');
                    } else {
                        $('.marks_modal .success_message').removeClass('d-none').html(data.message);
                        $('.marks_modal .error_message').addClass('d-none').html('');
                        let buffer = setInterval(function () {
                            $('.marks_modal .success_message').addClass('d-none').html('');
                            window.location.reload();
                            clearInterval(buffer)
                        }, 1000);

                    }
                }
            })


        });

        // Fees section
        $('.add_fees_button').click(function (e) {
            e.preventDefault();

            let form = $('.add_fees_form'), error = [];

            $('.add_fees_form input').each(function () {
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
                                window.location.reload()
                                clearInterval(buffer)
                            }, 1000);
                            // $('input[type="password"]').each(function () {
                            //     $(this).val('')
                            // })
                        }
                    }
                });
            }


        });

        $('.edit_fees_link').click(function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).data('href'),
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                    $('.fees_modal .fees_form').html(data);
                }
            });

        });

        $('.do_edit_fees_link').click(function (e) {
            e.preventDefault();
            let form = $('.fees_form');

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                dataType: 'json',
                data: form.serialize(),
                success:function (data) {
                    if (data.status === 0){
                        $('.fees_modal .error_message').removeClass('d-none').html(data.message);
                        $('.fees_modal .success_message').addClass('d-none').html('');
                    } else {
                        $('.fees_modal .success_message').removeClass('d-none').html(data.message);
                        $('.fees_modal .error_message').addClass('d-none').html('');
                        let buffer = setInterval(function () {
                            $('.fees_modal .success_message').addClass('d-none').html('');
                            window.location.reload();
                            clearInterval(buffer)
                        }, 1000);

                    }
                }
            })


        });


        $('.delete_link').click(function (e) {
            e.preventDefault();
            $('.delete_modal a').data('href', $(this).data('href')).addClass('action');
            $(this).addClass('deleted')

        });

        $('.delete_modal a').click(function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).data('href'),
                type: 'get',
                dataType: 'json',
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
                    }

                    $('.delete_modal').modal('hide');
                    $('.deleted').parents('tr').remove();
                }
            })
        })



    })
</script>
