<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
    $dbaccess = new DBAccess();
    $connection = $dbaccess->CreateDBConnection();
    $stmt = $connection->prepare("DELETE FROM games WHERE UserID = ?;");
    $stmt->execute(array($_GET['id']));
    $stmt = $connection->prepare("DELETE FROM suggestions WHERE UserID = ?;");
    $stmt->execute(array($_GET['id']));
    $stmt = $connection->prepare("SELECT ThemeID FROM votes WHERE UserID = ?;");
    $stmt->execute(array($_GET['id']));
    $rows = $stmt->fetchAll();
    foreach ($rows as $row)
    {
        $stmt = $connection->prepare("UPDATE themes SET TotalVotes = TotalVotes - 1 WHERE ID = ?;");
        $stmt->execute(array($row['ThemeID']));
    }
    $stmt = $connection->prepare("DELETE FROM votes WHERE UserID = ?;");
    $stmt->execute(array($_GET['id']));
    $stmt = $connection->prepare("DELETE FROM users WHERE ID = ?;");
    $stmt->execute(array($_GET['id']));
    header("location:/admin/viewusers/");
?> 