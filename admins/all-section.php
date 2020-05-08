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
        <h1 class="m-auto h3 mb-0 text-gray-800 text-uppercase">list of sections</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger d-none error_message text-center"></div>
            <div class="alert alert-success d-none success_message text-center"></div>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered sections_table">
                <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Name</th>
                    <th>Fees</th>
                    <th>Control</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($sections as $section) { ?>
                        <tr class="text-center">
                            <td><?= $section['id']?></td>
                            <td><?= $section['name']?></td>
                            <td><?= $section['fees']?></td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#delete_modal" data-href="<?=APP?>/controllers/sections/delete.php?id=<?=$section['id']?>" class="btn btn-danger btn-sm delete_link"><i class="fa fa-trash-alt"></i></a>
                                <a data-toggle="modal" data-target="#edit_modal" href="#" data-href="<?=APP?>/controllers/sections/get_info.php?id=<?=$section['id']?>" class="btn btn-info btn-sm edit_link"><i class="fa fa-pen-alt"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                <tr class="text-center">
                    <th>#</th>
                    <th>Name</th>
                    <th>Fees</th>
                    <th>Control</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

<!-- Edit section modal -->
<div class="modal fade edit_modal" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit teacher</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none error_message text-center"></div>
                <div class="alert alert-success d-none success_message text-center"></div>
                <form class="edit_section_form" action="<?=APP?>/controllers/sections/edit.php" method="post"></form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success btn-block do_edit_section_link" href="#">Edit</a>
            </div>
        </div>
    </div>
</div>
<!-- Delete section modal -->
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

        $('.sections_table').DataTable();

        $('.edit_link').click(function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).data('href'),
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                    $('.edit_modal .edit_section_form').html(data);
                }
            });

        });

        $('.do_edit_section_link').click(function (e) {
            e.preventDefault();
            let form = $('.edit_section_form');

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                dataType: 'json',
                data: form.serialize(),
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

            // let form = $('.add_section_form'), error = [];
            //
            // $('.add_section_form input').each(function () {
            //     if ($(this).val() === ''){
            //         error.push(true);
            //         $(this).css({
            //             border: '1px solid red'
            //         });
            //
            //         $(this).focus(function () {
            //             $(this).css({
            //                 border: '1px solid #ced4da'
            //             });
            //         });
            //     }
            //
            // });
            //
            // if (error.length === 0){
            //     $.ajax({
            //         url: form.attr('action'),
            //         type: form.attr('method'),
            //         dataType: 'json',
            //         data: form.serialize(),
            //         success: function (data) {
            //             if (data.status === 0){
            //                 $('.error_message').removeClass('d-none').html(data.message);
            //                 $('.success_message').addClass('d-none').html('');
            //             } else {
            //                 $('.success_message').removeClass('d-none').html(data.message);
            //                 $('.error_message').addClass('d-none').html('');
            //                 let buffer = setInterval(function () {
            //                     $('.success_message').addClass('d-none').html('');
            //                     clearInterval(buffer)
            //                 }, 3000);
            //                 // $('input[type="password"]').each(function () {
            //                 //     $(this).val('')
            //                 // })
            //             }
            //         }
            //     });
            // }

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
    })
</script>
