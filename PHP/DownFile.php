<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/31/15
 * Time: 9:26 PM
 */

ob_start();
$file = $_POST['file'];
$filepath = "/HealthLinkCSE360/PHP/uploads/".basename($file);
header('Location: '.$filepath);

?>