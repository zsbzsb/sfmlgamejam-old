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
        $mysqli = $dbaccess->CreateDBConnection();
        if ($NextJamQued)
        {
            if ($ThemeSuggestionsOpen)
            {
                $stmt = $mysqli->prepare("SELECT Title, BeginTime FROM jams WHERE ID = ?;");
                $stmt->bind_param("s", $ActiveJamID);
                $stmt->execute();
                $stmt->bind_result($Title, $BeginTime);
                $stmt->fetch();
                echo '<br><h3>Theme Suggestions are open for the '.$Title.'</h3>';
                echo '<br><h3>The jam will begin on '.$BeginTime.'</h3>';
            }
            else if ($ThemeVotingOpen)
            {
                $stmt = $mysqli->prepare("SELECT Title, BeginTime FROM jams WHERE ID = ?;");
                $stmt->bind_param("s", $ActiveJamID);
                $stmt->execute();
                $stmt->bind_result($Title, $BeginTime);
                $stmt->fetch();
                echo '<br><h3>Cast your vote now for the '.$Title.' theme</h3>';
                echo '<br><h3>The jam will begin on '.$BeginTime.'</h3>';
            }
            else
            {
                $stmt = $mysqli->prepare("SELECT Title, BeginTime FROM jams WHERE ID = ?;");
                $stmt->bind_param("s", $ActiveJamID);
                $stmt->execute();
                $stmt->bind_result($Title, $BeginTime);
                $stmt->fetch();
                echo '<br><h3>The '.$Title.' is around the corner</h3>';
                echo '<br><h3>It will begin on '.$BeginTime.' with theme selection a few weeks earlier</h3>';
            }
        }
        else if ($ThemeVisible)
        {
            $stmt = $mysqli->prepare("SELECT Title, ChosenTheme, BeginTime FROM jams WHERE ID = ?;");
            $stmt->bind_param("s", $ActiveJamID);
            $stmt->execute();
            $stmt->bind_result($Title, $ChosenTheme, $BeginTime);
            $stmt->fetch();
            echo '<br><h3>The theme has been chosen for '.$Title.'</h3>';
            echo '<br><h3>Base your game on "'.$ChosenTheme.'"!</h3>';
            echo '<br><h3>And get ready to rumble....<br> The jam will begin on '.$BeginTime.'</h3>';
        }
        else if ($JamRunning)
        {
            $stmt = $mysqli->prepare("SELECT Title, ChosenTheme, EndTime FROM jams WHERE ID = ?;");
            $stmt->bind_param("s", $ActiveJamID);
            $stmt->execute();
            $stmt->bind_result($Title, $ChosenTheme, $EndTime);
            $stmt->fetch();
            echo '<br><h3>The '.$Title.' is now in progress!</h3>';
            echo '<br><h3>Get a move on it and base your game on "'.$ChosenTheme.'"!</h3>';
            echo '<br><h3>Don'."'".'t forget the jam and all submissions will end on '.$EndTime.'</h3>';
        }
        else if ($JamCompleted)
        {
            $stmt = $mysqli->prepare("SELECT Title FROM jams WHERE ID = ?;");
            $stmt->bind_param("s", $ActiveJamID);
            $stmt->execute();
            $stmt->bind_result($Title);
            $stmt->fetch();
            echo '<br><h3>The '.$Title.' is now complete</h3>';
            echo '<br><h3>I hope you finished those games...</h3>';
            echo '<br><h3>Remember you can still work on cleaning up those game submissions</h3>';
        }
    }
?>

<!--<a class="twitter-timeline"  href="https://twitter.com/sfmlgamejam"  data-widget-id="422492659622481920">Tweets by @sfmlgamejam</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>-->
    
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>