<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/26/2015
 * Time: 11:29 PM
 */
session_start();
ob_start();
date_default_timezone_set ('America/Phoenix');
session_destroy();
$_SESSION['notification'] = 'You have been logged out.';
header('Location: index.php');
?>