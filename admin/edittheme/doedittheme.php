<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
$session = new LoginSession();
if ($session->GetIsAdmin())
{
    $id = $_POST['id'];
    $theme = $_POST['theme'];
    $title = $_POST['title'];
    $jamid = $_POST['jamid'];
    if (isset($_POST['canvote'])) $canvote = 1;
    else $canvote = 0;
    $dbaccess = new DBAccess();
    $mysqli = $dbaccess->CreateDBConnection();
    $stmt = $mysqli->prepare("UPDATE themes SET Theme = ?, CanVote = ? WHERE ID = ?;");
    $stmt->bind_param("sis", $theme, $canvote, $id);
    $stmt->execute();
    header("location:/admin/viewthemes?id=".$jamid."&title=".$title);
}
else
{
    header("location:/");
}
?>