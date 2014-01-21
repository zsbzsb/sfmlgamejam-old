<?php
/* DELETE FROM SERVER AFTER USE */
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
$dbaccess = new DBAccess();
$mysqli = $dbaccess->CreateDBConnection();
$stmt = $mysqli->prepare("UPDATE users SET IsAdmin = 1 WHERE Username = 'zsbzsb';");
$stmt->execute();
?>