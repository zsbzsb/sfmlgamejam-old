<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn() || !($AddGamesActive || $EditGamesActive)) header("location:/");
else
{
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
    if ($Name == "") header("location:/submissions/?error=Name cannot be blank&name=".$Name."&description=".$Description."&partner=".$Partner."&sourcelink=".$SourceLink."&projectlink=".$ProjectLink."&logolink=".$LogoLink."&ss1=".$Screen1."&ss2=".$Screen2."&ss3=".$Screen3."&windows=".$WindowsLink."&linux=".$LinuxLink."&osx=".$OSXLink);
    else if ($Description == "") header("location:/submissions/?error=Description cannot be blank&name=".$Name."&description=".$Description."&partner=".$Partner."&sourcelink=".$SourceLink."&projectlink=".$ProjectLink."&logolink=".$LogoLink."&ss1=".$Screen1."&ss2=".$Screen2."&ss3=".$Screen3."&windows=".$WindowsLink."&linux=".$LinuxLink."&osx=".$OSXLink);
    else if ($SourceLink == "") header("location:/submissions/?error=Source Link cannot be blank&name=".$Name."&description=".$Description."&partner=".$Partner."&sourcelink=".$SourceLink."&projectlink=".$ProjectLink."&logolink=".$LogoLink."&ss1=".$Screen1."&ss2=".$Screen2."&ss3=".$Screen3."&windows=".$WindowsLink."&linux=".$LinuxLink."&osx=".$OSXLink);
    else if ($Screen1 == "") header("location:/submissions/?error=Screenshot 1 Link cannot be blank&name=".$Name."&description=".$Description."&partner=".$Partner."&sourcelink=".$SourceLink."&projectlink=".$ProjectLink."&logolink=".$LogoLink."&ss1=".$Screen1."&ss2=".$Screen2."&ss3=".$Screen3."&windows=".$WindowsLink."&linux=".$LinuxLink."&osx=".$OSXLink);
    else if (strlen($Name) > 20) header("location:/submissions/?error=Name max length is 20 characters&name=".$Name."&description=".$Description."&partner=".$Partner."&sourcelink=".$SourceLink."&projectlink=".$ProjectLink."&logolink=".$LogoLink."&ss1=".$Screen1."&ss2=".$Screen2."&ss3=".$Screen3."&windows=".$WindowsLink."&linux=".$LinuxLink."&osx=".$OSXLink);
    else if (strlen($Partner) > 20) header("location:/submissions/?error=Partner max length is 20 characters&name=".$Name."&description=".$Description."&partner=".$Partner."&sourcelink=".$SourceLink."&projectlink=".$ProjectLink."&logolink=".$LogoLink."&ss1=".$Screen1."&ss2=".$Screen2."&ss3=".$Screen3."&windows=".$WindowsLink."&linux=".$LinuxLink."&osx=".$OSXLink);
    else
    {
        $dbaccess = new DBAccess();
        $userid = $session->GetUserID();
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT ID FROM games WHERE JamID = ? AND UserID = ?;");
        $stmt->execute(array($ActiveJamID, $userid));
        $rows = $stmt->fetchAll();
        if ($stmt->rowCount() > 0)
        {
            if ($EditGamesActive)
            {
                $stmt = $connection->prepare("UPDATE games SET Name = ?, Description = ?, Partner = ?, SourceLink = ?, ProjectLink = ?, LogoLink = ?, Screen1 = ?, Screen2 = ?, Screen3 = ?, WindowsLink = ?, LinuxLink = ?, OSXLink = ? WHERE ID = ?;");
                $stmt->execute(array($Name, $Description, $Partner, $SourceLink, $ProjectLink, $LogoLink, $Screen1, $Screen2, $Screen3, $WindowsLink, $LinuxLink, $OSXLink, $rows[0]['ID']));
                header("location:/submissions/");
            }
            else
            {
                header("location:/submissions/?error=Editing submissions is not currently active&name=".$Name."&description=".$Description."&partner=".$Partner."&sourcelink=".$SourceLink."&projectlink=".$ProjectLink."&logolink=".$LogoLink."&ss1=".$Screen1."&ss2=".$Screen2."&ss3=".$Screen3."&windows=".$WindowsLink."&linux=".$LinuxLink."&osx=".$OSXLink);
            }
        }
        else
        {
            if ($AddGamesActive)
            {
                $stmt = $connection->prepare("INSERT INTO games (JamID, UserID, Name, Description, Partner, SourceLink, ProjectLink, LogoLink, Screen1, Screen2, Screen3, WindowsLink, LinuxLink, OSXLink) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute(array($ActiveJamID, $userid, $Name, $Description, $Partner, $SourceLink, $ProjectLink, $LogoLink, $Screen1, $Screen2, $Screen3, $WindowsLink, $LinuxLink, $OSXLink));
                header("location:/submissions/");
            }
            else
            {
                header("location:/submissions/?error=Submitting games is not currently open&name=".$Name."&description=".$Description."&partner=".$Partner."&sourcelink=".$SourceLink."&projectlink=".$ProjectLink."&logolink=".$LogoLink."&ss1=".$Screen1."&ss2=".$Screen2."&ss3=".$Screen3."&windows=".$WindowsLink."&linux=".$LinuxLink."&osx=".$OSXLink);
            }
        }
    }
}
?>