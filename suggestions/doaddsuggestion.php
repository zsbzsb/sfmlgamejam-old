<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn() || !$ThemeSuggestionsOpen) header("location:/");
else
{
    $theme = trim($_POST['theme']);
    if ($theme == "") header("location:/suggestions/?error=Suggested Theme cannot be blank");
    else if (strlen($theme) > 20) header("location:/suggestions/?error=Max length is 20 characters&theme=".$theme);
    else
    {
        $dbaccess = new DBAccess();
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT ID FROM themes WHERE Theme = ? AND JamID = ?;");
        $stmt->execute(array($theme, $ActiveJamID));
        $stmt->fetchAll();
        if ($stmt->rowCount() > 0)
        {
            header("location:/suggestions/?error=This theme has already been suggested&theme=".$theme);
            return;
        }
        $stmt = $connection->prepare("SELECT ThemeID FROM suggestions WHERE JamID = ? AND UserID = ?;");
        $userid = $session->GetUserID();
        $stmt->execute(array($ActiveJamID, $userid));
        $stmt->fetchAll();
        if ($stmt->rowCount() >= $MaxSuggestions)
        {
            header("location:/suggestions/");
            return;
        }
        $stmt = $connection->prepare("INSERT INTO themes (JamID, Theme, TotalVotes, CanVote) VALUES (?, ?, 0, 1);");
        $stmt->execute(array($ActiveJamID, $theme));
        $themeid = $connection->lastInsertId();
        $stmt = $connection->prepare("INSERT INTO suggestions (JamID, ThemeID, UserID) VALUES (?, ?, ?);");
        $stmt->execute(array($ActiveJamID, $themeid, $userid));
        header("location:/suggestions/?suggested=".$theme);
    }
}
?>