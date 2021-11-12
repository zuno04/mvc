<?php
session_start();

if(isset($_SESSION['user'])){
    include_once('Views/pages/dashboard.php');
} else {
    header('Location: index.php?page=login');
}


