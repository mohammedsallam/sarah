<?php
ob_start();
session_start();

if (!isset($_SESSION['sign_type'])){
    header('location: login.php');
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
        <h1 class="h3 mb-0 text-gray-800">Home</h1>
    </div>

    <div class="row">

        <div class="container add-student">

            <h4 class="text-center titlu-categorie text-uppercase">add teacher</h4>

            <form action="" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Name</label>
                        <input type="text" class="form-control" name="name_std">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputLname">Last Name</label>
                        <input type="text" class="form-control" name="lname_std">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputdepartment">department</label>

                        <input type="text" class="form-control" id="department" name="department" value="A.I.A." readonly>

                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputYear">Year</label>

                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="year_std">




                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail">E-mail</label>
                        <input type="email" class="form-control" name="email_std">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPhone">Phone</label>
                        <input type="tel" class="form-control" name="Phone_std">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputUser">Username</label>
                        <input type="text" class="form-control" name="user_std">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword">password</label>
                        <input type="password" id="password" class="form-control" name="password_std">
                        <input type="checkbox" onclick="myFunction()">show password
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" name="submit">Add</button>
            </form>



            <?php if (isset($_SESSION['mesaj'])): ?>

                <div class="alert alert-success">
                    <?php

                    echo $_SESSION['mesaj'];
                    unset ($_SESSION['mesaj']);

                    ?>
                </div>
            <?php endif ?>

            <?php

            //Add student function


            $_SESSION['mesaj'] = "The student was added successfully";

            ?>

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
