<?php
session_name('linkedin-api');
session_start();
$_SESSION = array();
header("Location: connect-linkedin.php");
?>