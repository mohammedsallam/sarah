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

$sql = "SELECT * FROM teachers";
$result = mysqli_query($conn, $sql);
$teacherCount = $result->num_rows;

$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);
$studentCount = $result->num_rows;

$sql = "SELECT * FROM sections";
$result = mysqli_query($conn, $sql);
$sections = $result->fetch_all(MYSQLI_ASSOC);

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
            <form action="<?=APP?>/controllers/teachers/add.php" method="POST" class="add_teacher_form">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" name="name">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" class="form-control" name="last_name">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="username">User Name</label>
                        <input type="text" id="username" class="form-control" name="username">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" class="form-control" name="email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" class="form-control" name="phone">
                    </div>
<!--                    <div class="form-group col-md-3">-->
<!--                        <label for="phone">Section</label>-->
<!--                        <select name="section_id" class="form-control section_id">-->
<!--                            <option value="">Select </option>-->
<!--                            --><?php
//                            foreach ($sections as $section) { ?>
<!--                                <option value="--><?//=$section['id']?><!--">--><?//=$section['name']?><!--</option>-->
<!--                            --><?php //} ?>
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div class="form-group col-md-3">-->
<!--                        <label for="phone">year</label>-->
<!--                        <select name="year_id" class="form-control year_id">-->
<!--                            <option value="">Select Section</option>-->
<!--                        </select>-->
<!--                    </div>-->
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

            $('.add_teacher_form input, select').each(function () {
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

        // $('.section_id').change(function(){
        //     if ($(this).val() !== ''){
        //         $.ajax({
        //             url: '../controllers/teachers/get_section_year.php',
        //             type: 'GET',
        //             dataType: 'html',
        //             data: {section_id: $(this).val()},
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
