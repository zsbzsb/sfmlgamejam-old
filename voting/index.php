<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn() || !$ThemeVotingOpen) header("location:/");
?>
<?php $selected = "voting"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Vote on Themes</h2>

<?php
if (isset($_GET['error']))
{
    echo '<br><h3 style="color: red;">'.htmlspecialchars($_GET['error']).'</h3><br>';
}
?>

<?php
if (isset($_GET['voted']) && $_GET['voted'] == "1") echo "<br><h3>Thanks for voting!</h3><br>";
?>

    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
        include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
        $session = new LoginSession();
        $dbaccess = new DBAccess();
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT ThemeID FROM votes WHERE JamID = ? AND UserID = ?;");
        $userid = $session->GetUserID();
        $stmt->execute(array($ActiveJamID, $userid));
        $stmt->fetchAll();
        if ($stmt->rowCount() < $MaxVotes)
        {
            echo '
                <div id="form-container">
                <form name="VoteForm" method="post" action="/voting/dovote.php">
                <div class="row">
                    <span class="label" style="color: orange;">Theme</span>
                </div>';
            $stmt = $connection->prepare("SELECT ID, Theme FROM themes WHERE JamID = ? AND CanVote = 1;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            shuffle($rows);
            foreach ($rows as $row)
            {
                echo '
                    <div class="row" style="border-top: 1px solid black;">
                        <span class="label">'.htmlspecialchars($row['Theme']).'</span>
                        <input type="radio" name="themeid" value="'.$row['ID'].'" class="radiobutton">
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
                    <h3>You have voted the maximum number of times</h3>
                    <div id="form-container">
                    <div class="row">
                        <span class="label" style="color: orange;">Theme</span>
                    </div>';
                $stmt = $connection->prepare("SELECT Theme FROM themes WHERE JamID = ? AND CanVote = 1;");
                $stmt->execute(array($ActiveJamID));
                $rows = $stmt->fetchAll();
                foreach ($rows as $row)
                {
                    echo '
                        <div class="row">
                            <span class="label">'.htmlspecialchars($row['Theme']).'</span>
                        </div>';
                }
        }
    ?>
</div>

<br><h4>Use of multiple accounts (sock puppets) to influence results is strongly prohibited</h4>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
