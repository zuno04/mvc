<?php
// Controlleur Global ou Routeur

include_once('Models/db_connection.php');

if (!isset($_GET['page']) OR $_GET['page'] == 'index') {
    include_once('Controllers/index.php');
} elseif($_GET['page'] == 'login'){
    include_once('Controllers/login.php');
}  elseif($_GET['page'] == 'signup'){
    include_once('Controllers/signup.php');
} elseif($_GET['page'] == 'dashboard'){
    include_once('Controllers/dashboard.php');
} elseif($_GET['page'] == 'manage_users'){
    include_once('Controllers/manage_users.php');
} elseif($_GET['page'] == 'user_edit'){
    include_once('Controllers/user_edit.php');
} elseif($_GET['page'] == 'task_add'){
    include_once('Controllers/task_add.php');
} elseif($_GET['page'] == 'logout'){
    include_once('Controllers/logout.php');
}
else {
    header('Location: index.php');
}