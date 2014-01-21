<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
$session->Logout();
header("location:/");
?>