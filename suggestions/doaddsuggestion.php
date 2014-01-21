<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn() || !$ThemeSuggestionsActive) header("location:/");
else
{
    $theme = trim($_POST['theme']);
    if ($theme == "") header("location:/suggestions/?error=Suggested Theme cannot be blank");
    else
    {
        $dbaccess = new DBAccess();
        $mysqli = $dbaccess->CreateDBConnection();
        $stmt = $mysqli->prepare("SELECT ID FROM themes WHERE Theme = ?;");
        $stmt->bind_param("s", $theme);
        $stmt->execute();
        if ($stmt->fetch())
        {
            header("location:/suggestions/?error=This theme has already been suggested&theme=".$theme);
            return;
        }
        $stmt->close();
        $stmt = $mysqli->prepare("INSERT INTO themes (JamID, Theme, TotalVotes, CanVote) VALUES (?, ?, 0, 0);");
        $stmt->bind_param("ss", $ActiveJamID, $theme);
        $stmt->execute();
        $themeid = $mysqli->insert_id;
        $stmt->close();
        $userid = $session->GetUserID();
        $stmt = $mysqli->prepare("INSERT INTO suggestions (JamID, ThemeID, UserID) VALUES (?, ?, ?);");
        $stmt->bind_param("sss", $ActiveJamID, $themeid, $userid);
        $stmt->execute();
        $stmt->close();
        header("location:/suggestions/?suggested=".$theme);
    }
}
?>