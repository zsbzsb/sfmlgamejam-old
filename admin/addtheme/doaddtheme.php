<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
$session = new LoginSession();
if ($session->GetIsAdmin())
{
    $id = $_POST['id'];
    $theme = $_POST['theme'];
    $title = $_POST['title'];
    $dbaccess = new DBAccess();
    $mysqli = $dbaccess->CreateDBConnection();
    $stmt = $mysqli->prepare("INSERT INTO themes (JamID, Theme, TotalVotes) VALUES (?, ?, 0);");
    $stmt->bind_param("ss", $id, $theme);
    $stmt->execute();
    header("location:/admin/viewthemes/?id=".$id."&title=".$title);
}
else
{
    header("location:/");
}
?>