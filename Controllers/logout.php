<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('Models/user.php');

$disconnect_sucessful = disconnect($_SESSION['user']['id']);

if($disconnect_sucessful) {
    session_unset();
    session_destroy();
    
    header("Location: index.php?page=login");
}




