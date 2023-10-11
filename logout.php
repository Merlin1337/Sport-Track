<?php

require("async/config.php");

$_SESSION = array();
session_destroy();
setcookie('autologin', null, -1, '/', $_SERVER['HTTP_HOST'], false, true); // Delete rememberme cookie (autologin)

if (isset($_GET['status']) && $_GET['status'] == 'success-pwd') {
    header("Location: /login.php?status=pwd-changed"); exit;
} else {
    header("Location: /"); exit;

}

?>