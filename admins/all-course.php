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

$year_id=@$_GET['year_id'];
$section_id=@$_GET['section_id'];

$sql = "SELECT courses.*, years.name AS YNAME, sections.name AS SECNAME
        FROM courses LEFT JOIN years ON years.id=courses.year_id 
        LEFT JOIN sections ON sections.id=courses.section_id 
        WHERE courses.year_id = '$year_id' AND courses.section_id = '$section_id'";
$result = mysqli_query($conn, $sql);
$files = $result->fetch_all(MYSQLI_ASSOC);

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
        <h1 class="m-auto h3 mb-0 text-gray-800 text-uppercase">list of courses</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger d-none error_message text-center"></div>
            <div class="alert alert-success d-none success_message text-center"></div>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered students_table">
                <thead>
                <tr class="bg-dark text-light">
                    <th>ID</th>
                    <th>File name</th>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Semester</th>
                    <th>Download</th>
                    <th>Read</th>
                    <th>Control</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($files as $file) { ?>
                    <tr>
                        <td><?= $file['id']?></td>
                        <td><?= $file['name']?></td>
                        <td><?= $file['SECNAME']?></td>
                        <td><?= $file['YNAME']?></td>
                        <td><?= $file['semester']?></td>
                        <td>
                            <a target="_blank" href="<?= APP.$file['file']?>"><i class="fa fa-download"></i> Download</a>
                        </td>
                        <td>
                            <a target="_blank" href="<?= APP.'/controllers/courses/read.php?file='.$file['id']?>"><i class="fa fa-book"></i> Read</a>
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#delete_modal" data-href="<?=APP?>/controllers/courses/delete.php?id=<?=$file['id']?>&file=<?=$file['file']?>" class="btn btn-danger btn-sm delete_link"><i class="fa fa-trash-alt"></i></a>
                            <a data-toggle="modal" data-target="#edit_modal" href="#" data-href="<?=APP?>/controllers/courses/get_info.php?id=<?=$file['id']?>&file=<?=$file['file']?>&year_id=<?=$_GET['year_id']?>&section_id=<?=$_GET['section_id']?>" class="btn btn-info btn-sm edit_link"><i class="fa fa-pen-alt"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Edit file modal -->
<div class="modal fade edit_modal" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit exam</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none error_message text-center"></div>
                <div class="alert alert-success d-none success_message text-center"></div>
                <form class="edit_file_form" action="<?=APP?>/controllers/courses/edit.php" method="post" enctype="multipart/form-data"></form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success btn-block do_edit_file_link" href="#">Edit</a>
            </div>
        </div>
    </div>
</div>
<!-- Delete file modal -->
<div class="modal fade delete_modal" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Teacher</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h3><i class="fa fa-exclamation-triangle text-danger"></i> <span>Are you sure?</span></h3>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger btn-block" >Delete</a>
            </div>
        </div>
    </div>
</div>


<?php include('../layout/footer.php');?>

<script>
    $(document).ready(function () {

        $('.students_table').DataTable();

        $('.edit_link').click(function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).data('href'),
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                    $('.edit_modal .edit_file_form').html(data);
                }
            });

        });

        $('.do_edit_file_link').click(function (e) {
            e.preventDefault();
            let form = $('.edit_file_form'), formData = new FormData(form[0]),  error = [];

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                dataType: 'json',
                crossDomain: true,
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
                success:function (data) {
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

                    }
                }
            })


        });

        $('.delete_link').click(function (e) {
            e.preventDefault();
            $('.delete_modal a').attr('href', $(this).data('href'));
            $(this).addClass('deleted')
        });

        $('.delete_modal a').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
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

        $('.subject_id').change(function () {
            let subject_id = $(this).val();

            if (subject_id !== ''){
                $.ajax({
                    url: "<?=APP.'/controllers/files/get_subject_info.php'?>",
                    type: 'get',
                    dataType: 'json',
                    data: {subject_id: subject_id},
                    success: function (data) {
                        $('.semester').val(data.semester);
                        $('.year_id').val(data.year_id);
                        $('.year_name').val(data.name);
                    }
                })
            }

        });
    })
</script>
