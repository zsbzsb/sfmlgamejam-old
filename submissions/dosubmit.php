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
    $ProjectLink = trim($_POST['projectlink']);
    $LogoLink = trim($_POST['logolink']);
    $Screen1 = trim($_POST['ss1']);
    $Screen2 = trim($_POST['ss2']);
    $Screen3 = trim($_POST['ss3']);
    $WindowsLink = trim($_POST['windows']);
    $LinuxLink = trim($_POST['linux']);
    $OSXLink = trim($_POST['osx']);
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
        $mysqli = $dbaccess->CreateDBConnection();
        $stmt = $mysqli->prepare("SELECT ID FROM games WHERE JamID = ? AND UserID = ?;");
        $stmt->bind_param("ss", $ActiveJamID, $userid);
        $stmt->execute();
        $stmt->bind_result($ID);
        if ($stmt->fetch())
        {
            if ($EditGamesActive)
            {
                $stmt->close();
                $stmt = $mysqli->prepare("UPDATE games SET Name = ?, Description = ?, Partner = ?, SourceLink = ?, ProjectLink = ?, LogoLink = ?, Screen1 = ?, Screen2 = ?, Screen3 = ?, WindowsLink = ?, LinuxLink = ?, OSXLink = ? WHERE ID = ?;");
                $stmt->bind_param("sssssssssssss", $Name, $Description, $Partner, $SourceLink, $ProjectLink, $LogoLink, $Screen1, $Screen2, $Screen3, $WindowsLink, $LinuxLink, $OSXLink, $ID);
                $stmt->execute();
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
                $stmt->close();
                $stmt = $mysqli->prepare("INSERT INTO games (JamID, UserID, Name, Description, Partner, SourceLink, ProjectLink, LogoLink, Screen1, Screen2, Screen3, WindowsLink, LinuxLink, OSXLink) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssssssssss", $ActiveJamID, $userid, $Name, $Description, $Partner, $SourceLink, $ProjectLink, $LogoLink, $Screen1, $Screen2, $Screen3, $WindowsLink, $LinuxLink, $OSXLink);
                $stmt->execute();
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