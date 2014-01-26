<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
    $dbaccess = new DBAccess();
    $connection = $dbaccess->CreateDBConnection();
    $stmt = $connection->prepare("UPDATE users SET IsBanned = ? WHERE ID = ?;");
    $stmt->execute(array($_GET['banned'], $_GET['id']));
    header("location:/admin/viewusers/")
?> 