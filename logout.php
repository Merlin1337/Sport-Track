<?php

require("async/config.php");

$_SESSION = array();
session_destroy();
setcookie('autologin', null, -1, '/', $_SERVER['HTTP_HOST'], false, true); // Delete rememberme cookie (autologin)


header("Location: /"); exit;


?>