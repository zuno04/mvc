<?php
// Controlleur Global ou Routeur

if (session_status() == PHP_SESSION_NONE) {
    session_start();

    $currentTime = time();
    if(isset($_SESSION['user']) && isset($_SESSION['expire']) && $currentTime > $_SESSION['expire']) {
        header('Location: index.php?page=logout');
    }
}

include_once('Models/db_connection.php');

define("HOST_URL", $_SERVER['SERVER_NAME'] . explode("?", $_SERVER["REQUEST_URI"])[0]);


// var_dump(HOST_URL);die;

if (!isset($_GET['page']) OR $_GET['page'] == 'index') {
    include_once('Controllers/index.php');
} elseif($_GET['page'] == 'login'){
    include_once('Controllers/login.php');
} elseif($_GET['page'] == 'settings'){
    include_once('Controllers/settings.php');
} elseif($_GET['page'] == 'signup'){
    include_once('Controllers/signup.php');
} elseif($_GET['page'] == 'dashboard'){
    include_once('Controllers/dashboard.php');
} elseif($_GET['page'] == 'manage_users'){
    include_once('Controllers/manage_users.php');
} elseif($_GET['page'] == 'user_edit'){
    include_once('Controllers/user_edit.php');
} elseif($_GET['page'] == 'task_add'){
    include_once('Controllers/task_add.php');
} elseif($_GET['page'] == 'task_delete'){
    include_once('Controllers/task_delete.php');
} elseif($_GET['page'] == 'logout'){
    include_once('Controllers/logout.php');
}
else {
    header('Location: index.php');
}