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
    $connection = $dbaccess->CreateDBConnection();
    $stmt = $connection->prepare("INSERT INTO themes (JamID, Theme, TotalVotes, CanVote) VALUES (?, ?, 0, 1);");
    $stmt->execute(array($id, $theme));
    header("location:/admin/viewthemes/?id=".$id."&title=".$title);
}
else
{
    header("location:/");
}
?>