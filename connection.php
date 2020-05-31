<?php
require_once 'config.php';

$conn = @mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$char = @mysqli_set_charset($conn, 'utf8');

if($conn === false){
    die("<b>The target machine not responding...</b>" );
}