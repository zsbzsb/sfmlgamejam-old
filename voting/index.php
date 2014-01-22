<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn() || !$ThemeVotingActive) header("location:/");
?>
<?php $selected = "voting"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Vote on Themes</h2>

<?php
if (isset($_GET['voted']) && $_GET['voted'] == "1") echo "</br><h3>Thanks for voting!</h3></br>";
?>

<div id="form-container">
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
        include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
        $session = new LoginSession();
        $dbaccess = new DBAccess();
        $mysqli = $dbaccess->CreateDBConnection();
        $stmt = $mysqli->prepare("SELECT ThemeID FROM votes WHERE JamID = ? AND UserID = ?;");
        $userid = $session->GetUserID();
        $stmt->bind_param("ss", $ActiveJamID, $userid);
        $stmt->execute();
        $stmt->bind_result($ThemeID);
        $count = 0;
        while ($stmt->fetch())
        {
            $count += 1;
        }
        $stmt->close();
        if ($count < $MaxVotes)
        {
            echo '
                <form name="VoteForm" method="post" action="/voting/dovote.php">
                <div class="row">
                    <span class="label" style="color: orange;">Theme</span>
                </div>';
            $stmt = $mysqli->prepare("SELECT ID, Theme FROM themes WHERE JamID = ? AND CanVote = 1;");
            $stmt->bind_param("s", $ActiveJamID);
            $stmt->execute();
            $stmt->bind_result($ID, $Theme);
            while ($stmt->fetch())
            {
                echo '
                    <div class="row">
                        <span class="label">'.$Theme.'</span>
                        <input type="radio" name="themeid" value="'.$ID.'" class="radiobutton">
                    </div>';
            }
            echo '
                <div class="row">
                <input type="submit" value="Vote" class="button">
                </div>
                </form>';
        }
        else
        {
                echo '
                    <div class="row">
                        <span class="label" style="color: orange;">Theme</span>
                    </div>';
                $stmt = $mysqli->prepare("SELECT Theme FROM themes WHERE JamID = ? AND CanVote = 1;");
                $stmt->bind_param("s", $ActiveJamID);
                $stmt->execute();
                $stmt->bind_result($Theme, $TotalVotes);
                while ($stmt->fetch())
                {
                    echo '
                        <div class="row">
                            <span class="label">'.$Theme.'</span>
                        </div>';
                }
        }
    ?>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
