<?php
session_start();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\EmailFormat;


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../../connection.php';



    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $error = [];

    foreach ($_POST as $key => $item) {
        if (empty($item)){
            $key = str_replace('_', ' ', $key);
            $error[] = "Please fill $key fields";
            break;
        }
    }

    if (empty($error) == false){
        echo json_encode(['status' => 0, 'message' => $error]);
    } else{
        if ($email == false){
            echo json_encode(['status' => 0, 'message' => 'Email syntax un valid']);
            return false;
        }

        $sql = "SELECT email FROM students WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows == 0){
            echo json_encode(['status' => 0, 'message' => 'Email Not found']);
            return false;
        }

        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        $password = implode($pass);
        $hashedPassword = password_hash($password, CRYPT_BLOWFISH);


        $mail = new PHPMailer();
        try{
//            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = Host;
            $mail->SMTPAuth   = true;
            $mail->Username   = USER;
            $mail->Password   = PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = PORT;

            $mail->setFrom(USER, NAME);
            $mail->addAddress($email, $email);
            $mail->isHTML(true);
            $mail->Subject = 'Reset password';
            $mail->Body    = EmailFormat::format($email, $password);
            $mail->send();

            $sql = "UPDATE students SET password='$hashedPassword' WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            echo json_encode(['status' => 1, 'message' => 'Reset password successfully please check your email box']);

        } catch (Exception $e) {

            echo json_encode(['status' => 0, 'message' => 'We face problem while sending email : ' . $mail->ErrorInfo]);

        }

    }

} else {
    header("location:" . $_SERVER['HTTP_REFERER']);
}