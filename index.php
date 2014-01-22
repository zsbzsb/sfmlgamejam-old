<?php $selected = "home"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h3>Hello and welcome to the SFML Game Jam website!</h3></br>

<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
    $session = new LoginSession();
    if (!$session->GetIsLoggedIn()) echo '</br><h3>To continue please register and login</h3>';
    else
    {
        $dbaccess = new DBAccess();
        $mysqli = $dbaccess->CreateDBConnection();
        if ($ThemeSuggestionsActive)
        {
            $stmt = $mysqli->prepare("SELECT Title, BeginTime FROM jams WHERE ID = ?;");
            $stmt->bind_param("s", $ActiveJamID);
            $stmt->execute();
            $stmt->bind_result($Title, $BeginTime);
            $stmt->fetch();
            echo '</br><h3>Theme Suggestions are open for the '.$Title.'</h3>';
            echo '</br><h3>The Jam will begin on '.$BeginTime.'</h3>';
        }
        else if ($ThemeVotingActive)
        {
            $stmt = $mysqli->prepare("SELECT Title, BeginTime FROM jams WHERE ID = ?;");
            $stmt->bind_param("s", $ActiveJamID);
            $stmt->execute();
            $stmt->bind_result($Title, $BeginTime);
            $stmt->fetch();
            echo '</br><h3>Theme Voting is active for the '.$Title.'</h3>';
            echo '</br><h3>The Jam will begin on '.$BeginTime.'</h3>';
        }
        else if ($JamActive)
        {
            $stmt = $mysqli->prepare("SELECT Title, EndTime, ChosenTheme FROM jams WHERE ID = ?;");
            $stmt->bind_param("s", $ActiveJamID);
            $stmt->execute();
            $stmt->bind_result($Title, $EndTime, $ChosenTheme);
            $stmt->fetch();
            echo '</br><h3>The '.$Title.' is now running!</h3>';
            echo '<br><h3>Make sure your games are based on "'.$ChosenTheme.'" and remember have fun!</h3>';
            echo '</br><h3>The Jam will end on '.$EndTime.'. Be sure to get your game submissions in!</h3>';
        }
        else if ($ThemeVotingActive)
        {
            $stmt = $mysqli->prepare("SELECT Title, BeginTime FROM jams WHERE ID = ?;");
            $stmt->bind_param("s", $ActiveJamID);
            $stmt->execute();
            $stmt->bind_result($Title, $BeginTime);
            $stmt->fetch();
            echo '</br><h3>The '.$Title.' will begin on '.$BeginTime.'</h3>';
            echo '</br><h3>Remember, Theme Selection will begin a week before</h3>';
        }
    }
?>

<!--<a class="twitter-timeline"  href="https://twitter.com/sfmlgamejam"  data-widget-id="422492659622481920">Tweets by @sfmlgamejam</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>-->
    
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>