<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
$session = new LoginSession();
if ($session->GetIsAdmin())
{
    if (isset($_POST['galleryopen'])) $galleryopen = 1;
    else $galleryopen = 0;
    $id = $_POST['id'];
    $title = $_POST['title'];
    $begintime = $_POST['begintime'];
    $endtime = $_POST['endtime'];
    $chosentheme = $_POST['chosentheme'];
    $dbaccess = new DBAccess();
    $connection = $dbaccess->CreateDBConnection();
    $stmt = $connection->prepare("UPDATE jams SET Title = ?, BeginTime = ?, EndTime = ?, ChosenTheme = ?, GalleryOpen = ? WHERE ID = ?;");
    $stmt->execute(array($title, $begintime, $endtime, $chosentheme, $galleryopen, $id));
    header("location:/admin/viewjams/");
}
else
{
    header("location:/");
}
?>