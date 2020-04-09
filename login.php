<?php
session_start();
require('connection.php');
include('layout/header.php');
if (isset($_SESSION['sign_type'])){
    header('location: ' . $_SESSION['location']);
    exit();
}

?>
<div class="col-md-4 m-auto">
    <div class="card card-signin my-5">
        <div class="card-body">
            <?php
                if (isset($_SESSION['message'])){ ?>
                    <div class="alert alert-danger text-center"><?= $_SESSION['message'] ?></div>
                <?php }
                    unset($_SESSION['message'])
                ?>
            <h5 class="card-title text-center title">Sign In</h5>
            <form class="form-signin" method="post" action="controllers/checklogin.php">
                <input type="hidden" class="sign_type" name="sign_type" value="1">
                <div class="form-label-group">
                    <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
                    <label for="inputEmail">Email address</label>
                </div>

                <div class="form-label-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <label for="inputPassword">Password</label>
                </div>

                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Remember password</label>
                </div>
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
                <hr class="my-4">
                <div class="row">
                    <a href="#" class="btn col-md-12 sign_as font-weight-bold text-primary" data-type="1"> Sign in as admin</a>
                    <a href="#" class="btn col-md-6 sign_as" data-type="2"> Sign in as teacher</a>
                    <a href="#" class="btn col-md-6 sign_as" data-type="3"> Sign in as student</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('layout/footer.php'); ?>

<script>
    $(document).ready(function () {
        $('.sign_as').click(function (e) {
            e.preventDefault();
            $(this).addClass('font-weight-bold text-primary');
            $(this).siblings().removeClass('font-weight-bold text-primary');
            $('.sign_type').val($(this).data('type'))


        })
    });
</script>
