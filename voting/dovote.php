<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn() || !$ThemeVotingOpen) header("location:/");
else
{
    if (!isset($_POST['themeid']))
    {
        header("location:/voting/");
        return;
    }
    $themeid = $_POST['themeid'];
    $dbaccess = new DBAccess();
    $connection = $dbaccess->CreateDBConnection();
    $stmt = $connection->prepare("SELECT ThemeID FROM votes WHERE JamID = ? AND UserID = ?;");
    $userid = $session->GetUserID();
    $stmt->execute(array($ActiveJamID, $userid));
    $rows = $stmt->fetchAll();
    if ($stmt->rowCount() >= $MaxVotes)
    {
        header("location:/voting/");
        return;
    }
    foreach ($rows as $row)
    {
        if ($row['ThemeID'] == $themeid)
        {
            header("location:/voting/?error=You may only vote once per theme");
            return;
        }
    }
    $stmt = $connection->prepare("UPDATE themes SET TotalVotes = TotalVotes + 1 WHERE ID = ?;");
    $stmt->execute(array($themeid));
    $userid = $session->GetUserID();
    $stmt = $connection->prepare("INSERT INTO votes (JamID, ThemeID, UserID) VALUES (?, ?, ?);");
    $stmt->execute(array($ActiveJamID, $themeid, $userid));
    header("location:/voting/?voted=1");
}
?>