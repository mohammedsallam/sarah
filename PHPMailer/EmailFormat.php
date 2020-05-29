<?php
namespace PHPMailer\PHPMailer;

class EmailFormat
{

    public static function format($email, $code)
    {
        $message = "<div><img style='    width: 16%;
    border-radius: 10px;' src='http://placehold.it/200/200'>";
        $message .= "<h1 style='

                                background: #3c434c;
                                width: 32%;
                                border-radius: 5px;
                                color: #fff;
                                height: 50px;
                                text-align: center;
                                
                        '>Forget password</h1>";
        $message .= "<h2>Welcome $email </h2>";
        $message .= "<p> please use below code as temporary password to login  </p>";
        $message .= "<span>Code: </span><b>$code</b>";
        $message .= "</div>";
        return  $message;
    }
}