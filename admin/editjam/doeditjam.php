<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
$session = new LoginSession();
if ($session->GetIsAdmin())
{
    $id = $_POST['id'];
    $title = $_POST['title'];
    $begintime = $_POST['begintime'];
    $endtime = $_POST['endtime'];
    $chosentheme = $_POST['chosentheme'];
    $dbaccess = new DBAccess();
    $mysqli = $dbaccess->CreateDBConnection();
    $stmt = $mysqli->prepare("UPDATE jams SET Title = ?, BeginTime = ?, EndTime = ?, ChosenTheme = ? WHERE ID = ?;");
    $stmt->bind_param("sssss", $title, $begintime, $endtime, $chosentheme, $id);
    $stmt->execute();
    header("location:/admin/viewjams/");
}
else
{
    header("location:/");
}
?>