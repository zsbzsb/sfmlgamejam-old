<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
$session = new LoginSession();
if ($session->GetIsAdmin())
{
    $title = $_POST['title'];
    $begintime = $_POST['begintime'];
    $endtime = $_POST['endtime'];
    $dbaccess = new DBAccess();
    $mysqli = $dbaccess->CreateDBConnection();
    $stmt = $mysqli->prepare("INSERT INTO jams (Title, BeginTime, EndTime, ChosenTheme) VALUES (?, ?, ?, '');");
    $stmt->bind_param("sss", $title, $begintime, $endtime);
    $stmt->execute();
    header("location:/admin/viewjams");
}
else
{
    header("location:/");
}
?>