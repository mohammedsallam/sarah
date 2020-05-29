<?php
include 'helper.php';
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'project');
define('APP', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.basename(realpath(__DIR__)));
define('APP_DIR', realpath(__DIR__));
define('ASSETS', APP.'/assets/');

define('Host', 'smtp.gmail.com');
define('PORT', 587); // 587 - 465
define('USER', 'mosallam06@gmail.com');
define('NAME', 'University App');
define('PASS', 'thggiodvpht/h0530345592');

include 'PHPMailer/PHPMailer.php';
include 'PHPMailer/Exception.php';
include 'PHPMailer/EmailFormat.php';
include 'PHPMailer/SMTP.php';


