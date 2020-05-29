<?php
ob_start();
session_start();

require('../connection.php');
include('../layout/header.php');

?>

<style>
    .loader > div{
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        background: rgba(0,0,0, .8);
        z-index: 999999;
    }

    .loader .spinner-border {
        width: 10rem;
        height: 10rem;
    }

</style>

<div class="loader d-none">
    <div class="d-flex justify-content-center align-items-center">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only"></span>
        </div>
    </div>
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4 m-auto">
                <div class="card card-signin my-5">
                    <div class="card-header">
                        <div class="alert alert-danger d-none error_message text-center"></div>
                        <div class="alert alert-success d-none success_message text-center"></div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center title">Forget password</h5>
                        <form class="reset_password_form" method="post" action="<?=APP.'/controllers/students/forget_password.php'?>">
                            <div class="form-group">
                                <label for="inputEmail">Email address</label>
                                <input type="email" name="email" class="form-control" placeholder="Email address" autofocus>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-primary reset_password_button" value="Send">
                            </div>
                            <a  href="<?=APP.'/login.php'?>" class="col-md-6"><i class="fa fa-sign-in-alt"></i> Login in ?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php include('../layout/footer.php');?>

<script>
    $(document).ready(function () {


        $('.reset_password_button').click(function (e) {
            e.preventDefault();

            $('.loader').removeClass('d-none');
            let form = $('.reset_password_form'), formData = new FormData(form[0]),  error = [];

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
                        $('.error_message').removeClass('d-none').html(data.message);
                        $('.success_message').addClass('d-none').html('');
                        $('.loader').addClass('d-none');
                    } else {
                        $('.loader').addClass('d-none');
                        $('.success_message').removeClass('d-none').html(data.message);
                        $('.error_message').addClass('d-none').html('');
                        $('input[type="email"]').val('')
                        let buffer = setInterval(function () {
                            $('.success_message').addClass('d-none').html('');
                            // window.location.reload();
                            clearInterval(buffer)
                        }, 3000);

                    }
                }
            })


        });

    })
</script>
