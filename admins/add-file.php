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
$sql = "SELECT * FROM subjects WHERE section_id = '$section_id'";
$result = mysqli_query($conn, $sql);
$subjects = $result->fetch_all(MYSQLI_ASSOC);


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
        <h1 class="m-auto h3 mb-0 text-gray-800 text-uppercase">add file</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger  d-none error_message text-center"></div>
            <div class="alert alert-success d-none success_message text-center"></div>
        </div>
        <div class="container add-student">
            <form action="<?=APP?>/controllers/files/add.php" method="POST" class="add_file_form" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">File Name</label>
                        <input type="text" id="name" class="form-control" name="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Department</label>
                        <input readonly type="text" class="form-control bg-light" value="<?=@$_GET['section']?>">
                        <input type="hidden" name="section_id" class="form-control" value="<?=@$_GET['section_id']?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="subject_id">Subject</label>
                        <select name="subject_id" id="subject_id" class="form-control subject_id">
                            <option value="">Select Subject</option>
                            <?php
                            foreach ($subjects as $subject) { ?>
                                <option value="<?= $subject['id']?>"><?= $subject['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Year</label>
                        <input readonly type="text" class="form-control bg-light year_name">
                        <input type="hidden" name="year_id" class="form-control year_id">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Semester</label>
                        <input readonly type="text" name="semester" class="form-control bg-light semester">
                    </div>
                    <div class="form-group col-md-6 pt-2">
                        <label for="file" class="btn btn-info btn-block mt-4"><i class="fa fa-file"></i> Choose file</label>
                        <input type="file" id="file" name="file" class="d-none">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block add_file_button" name="submit">Add</button>
            </form>

        </div>
    </div>

</div>

<?php include('../layout/footer.php');?>

<script>
    $(document).ready(function () {

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

        $('.add_file_button').click(function (e) {
            e.preventDefault();

            let form = $('.add_file_form'), formData = new FormData(form[0]),  error = [];

            $('.add_file_form input, select').each(function () {
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
        })
    })
</script>
