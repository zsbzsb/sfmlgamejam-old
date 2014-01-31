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
    $connection = $dbaccess->CreateDBConnection();
    $stmt = $connection->prepare("INSERT INTO jams (Title, BeginTime, EndTime, ChosenTheme, CountdownStart, CountdownEnd, GalleryOpen) VALUES (?, ?, ?, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);");
    $stmt->execute(array($title, $begintime, $endtime));
    header("location:/admin/viewjams/");
}
else
{
    header("location:/");
}
?>