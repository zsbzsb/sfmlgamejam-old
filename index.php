<?php $selected = "home"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h3>Hello and welcome to the SFML Game Jam website!</h3><br>

<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
    $session = new LoginSession();
    if (!$session->GetIsLoggedIn()) echo '<br><h3>To continue please register and login</h3>';
    else
    {
        $dbaccess = new DBAccess();
        $connection = $dbaccess->CreateDBConnection();
        if ($NextJamQued)
        {
            if ($ThemeSuggestionsOpen)
            {
                $stmt = $connection->prepare("SELECT Title, BeginTime FROM jams WHERE ID = ?;");
                $stmt->execute(array($ActiveJamID));
                $rows = $stmt->fetchAll();
                echo '<br><h3>Theme Suggestions are open for the '.$rows[0]['Title'].'</h3>';
                echo '<br><h3>The jam will begin on '.$rows[0]['BeginTime'].'</h3>';
            }
            else if ($ThemeVotingOpen)
            {
                $stmt = $connection->prepare("SELECT Title, BeginTime FROM jams WHERE ID = ?;");
                $stmt->execute(array($ActiveJamID));
                $rows = $stmt->fetchAll();
                echo '<br><h3>Cast your vote now for the '.$rows[0]['Title'].' theme</h3>';
                echo '<br><h3>The jam will begin on '.$rows[0]['BeginTime'].'</h3>';
            }
            else
            {
                $stmt = $connection->prepare("SELECT Title, BeginTime FROM jams WHERE ID = ?;");
                $stmt->execute(array($ActiveJamID));
                $rows = $stmt->fetchAll();
                echo '<br><h3>The '.$rows[0]['Title'].' is around the corner</h3>';
                echo '<br><h3>It will begin on '.$rows[0]['BeginTime'].' with theme selection a few weeks earlier</h3>';
            }
        }
        else if ($ThemeVisible)
        {
            $stmt = $connection->prepare("SELECT Title, ChosenTheme, BeginTime FROM jams WHERE ID = ?;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            echo '<br><h3>The theme has been chosen for '.$rows[0]['Title'].'</h3>';
            echo '<br><h3>Base your game on "'.$rows[0]['ChosenTheme'].'"!</h3>';
            echo '<br><h3>And get ready to rumble....<br> The jam will begin on '.$rows[0]['BeginTime'].'</h3>';
        }
        else if ($JamRunning)
        {
            $stmt = $connection->prepare("SELECT Title, ChosenTheme, EndTime FROM jams WHERE ID = ?;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            echo '<br><h3>The '.$rows[0]['Title'].' is now in progress!</h3>';
            echo '<br><h3>Get a move on it and base your game on "'.$rows[0]['ChosenTheme'].'"!</h3>';
            echo '<br><h3>Don'."'".'t forget the jam and all submissions will end on '.$rows[0]['EndTime'].'</h3>';
        }
        else if ($JamCompleted)
        {
            $stmt = $connection->prepare("SELECT Title FROM jams WHERE ID = ?;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            echo '<br><h3>The '.$rows[0]['Title'].' is now complete</h3>';
            echo '<br><h3>I hope you finished those games...</h3>';
            echo '<br><h3>Remember you can still work on cleaning up those game submissions</h3>';
        }
    }
?>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>