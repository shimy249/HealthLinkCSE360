<?php
/**
 * Created by PhpStorm.
 * User: Ryan
 * Date: 10/26/2015
 * Time: 11:29 PM
 */
session_start();
date_default_timezone_set ('America/Phoenix');
if (isset($_SESSION['user'])) unset($_SESSION['user']);
if (isset($_SESSION['type'])) unset($_SESSION['type']);
if (isset($_SESSION['userID'])) unset($_SESSION['userID']);
$_SESSION['notification'] = 'You have been logged out.';
header('Location: index.php');
?>