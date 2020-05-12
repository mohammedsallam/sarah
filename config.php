<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'project');
define('APP', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.basename(realpath(__DIR__)));
define('APP_DIR', realpath(__DIR__));
define('ASSETS', APP.'/assets/');


