<?php
// Controlleur Global ou Routeur

include_once('Models/db_connection.php');

if (!isset($_GET['page']) OR $_GET['page'] == 'index') {
    include_once('Controllers/index.php');
} elseif( $_GET['page'] == 'login'){
    include_once('Controllers/login.php');
} elseif( $_GET['page'] == 'dashboard'){
    include_once('Controllers/dashboard.php');
} elseif( $_GET['page'] == 'logout'){
    include_once('Controllers/logout.php');
}
else {
    header('Location: index.php');
}