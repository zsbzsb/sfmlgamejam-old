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
    $mysqli = $dbaccess->CreateDBConnection();
    $stmt = $mysqli->prepare("UPDATE themes SET TotalVotes = TotalVotes + 1 WHERE ID = ?;");
    $stmt->bind_param("s", $themeid);
    $stmt->execute();
    $stmt->close();
    $userid = $session->GetUserID();
    $stmt = $mysqli->prepare("INSERT INTO votes (JamID, ThemeID, UserID) VALUES (?, ?, ?);");
    $stmt->bind_param("sss", $ActiveJamID, $themeid, $userid);
    $stmt->execute();
    $stmt->close();
    header("location:/voting/?voted=1");
}
?>