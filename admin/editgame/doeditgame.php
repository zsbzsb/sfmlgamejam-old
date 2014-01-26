<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
else
{
    $ID = $_POST['id'];
    $Name = trim($_POST['name']);
    $Description = trim($_POST['description']);
    $Partner = trim($_POST['partner']);
    $SourceLink = trim($_POST['sourcelink']);
    if (!(strpos($SourceLink,'//') !== false) && $SourceLink != "") $SourceLink = '//'.$SourceLink;
    $ProjectLink = trim($_POST['projectlink']);
    if (!(strpos($ProjectLink,'//') !== false) && $ProjectLink != "") $ProjectLink = '//'.$ProjectLink;
    $LogoLink = trim($_POST['logolink']);
    if (!(strpos($LogoLink,'//') !== false) && $LogoLink != "") $LogoLink = '//'.$LogoLink;
    $Screen1 = trim($_POST['ss1']);
    if (!(strpos($Screen1,'//') !== false) && $Screen1 != "") $Screen1 = '//'.$Screen1;
    $Screen2 = trim($_POST['ss2']);
    if (!(strpos($Screen2,'//') !== false) && $Screen2 != "") $Screen2 = '//'.$Screen2;
    $Screen3 = trim($_POST['ss3']);
    if (!(strpos($Screen3,'//') !== false) && $Screen3 != "") $Screen3 = '//'.$Screen3;
    $WindowsLink = trim($_POST['windows']);
    if (!(strpos($WindowsLink,'//') !== false) && $WindowsLink != "") $WindowsLink = '//'.$WindowsLink;
    $LinuxLink = trim($_POST['linux']);
    if (!(strpos($LinuxLink,'//') !== false) && $LinuxLink != "") $LinuxLink = '//'.$LinuxLink;
    $OSXLink = trim($_POST['osx']);
    if (!(strpos($OSXLink,'//') !== false) && $OSXLink != "") $OSXLink = '//'.$OSXLink;
    $dbaccess = new DBAccess();
    $userid = $session->GetUserID();
    $connection = $dbaccess->CreateDBConnection();
    $stmt = $connection->prepare("UPDATE games SET Name = ?, Description = ?, Partner = ?, SourceLink = ?, ProjectLink = ?, LogoLink = ?, Screen1 = ?, Screen2 = ?, Screen3 = ?, WindowsLink = ?, LinuxLink = ?, OSXLink = ? WHERE ID = ?;");
    $stmt->execute(array($Name, $Description, $Partner, $SourceLink, $ProjectLink, $LogoLink, $Screen1, $Screen2, $Screen3, $WindowsLink, $LinuxLink, $OSXLink, $ID));
    header("location:/admin/editgame/?id=".$_POST['id']);
}
?>