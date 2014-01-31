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
            $stmt = $connection->prepare("SELECT CountdownStart FROM jams WHERE ID = ?;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            date_default_timezone_set('UTC');
            echo '<script src="countdown.js" type="text/javascript"></script>';
            $tm = strtotime($rows[0]['CountdownStart']);
            $diff = $tm - time();
            $hi = "hour";
            if ($diff >= 86400) $hi = "day";
            echo '<div style="display: block; margin: 15px auto; width: 300px; height 60px;">
                  <script type="application/javascript">
                        var countdown = new Countdown({
                        time: '.$diff.',
                        width:240, 
                        height:60,  
                        rangeHi:"'.$hi.'",
                        style:"flip" }); </script></div>';
        }
        else if ($WaitingOnTheme)
        {
            $stmt = $connection->prepare("SELECT Title, BeginTime FROM jams WHERE ID = ?;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            echo '<br><h3>The theme will be announced for the '.$rows[0]['Title'].' in just a short while</h3>';
            echo '<br><h3>Keep watching this page for the theme announcement</h3>';
            echo '<br><h3>Oh, and for the billionth time, the jam will begin on '.$rows[0]['BeginTime'].'</h3>';
            $stmt = $connection->prepare("SELECT CountdownStart FROM jams WHERE ID = ?;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            date_default_timezone_set('UTC');
            echo '<script src="countdown.js" type="text/javascript"></script>';
            $tm = strtotime($rows[0]['CountdownStart']);
            $diff = $tm - time();
            $hi = "hour";
            if ($diff >= 86400) $hi = "day";
            echo '<div style="display: block; margin: 15px auto; width: 300px; height 60px;">
                  <script type="application/javascript">
                        var countdown = new Countdown({
                        time: '.$diff.',
                        width:240, 
                        height:60,  
                        rangeHi:"'.$hi.'",
                        style:"flip" }); </script></div>';
        }
        else if ($ThemeVisible)
        {
            $stmt = $connection->prepare("SELECT Title, ChosenTheme, BeginTime FROM jams WHERE ID = ?;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            echo '<br><h3>The theme has been chosen for '.$rows[0]['Title'].'</h3>';
            echo '<br><h3>Base your game on "'.$rows[0]['ChosenTheme'].'"!</h3>';
            echo '<br><h3>And get ready to rumble....<br> The jam will begin on '.$rows[0]['BeginTime'].'</h3>';
            $stmt = $connection->prepare("SELECT CountdownStart FROM jams WHERE ID = ?;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            date_default_timezone_set('UTC');
            echo '<script src="countdown.js" type="text/javascript"></script>';
            $tm = strtotime($rows[0]['CountdownStart']);
            $diff = $tm - time();
            $hi = "hour";
            if ($diff >= 86400) $hi = "day";
            echo '<div style="display: block; margin: 15px auto; width: 300px; height 60px;">
                  <script type="application/javascript">
                        var countdown = new Countdown({
                        time: '.$diff.',
                        width:240, 
                        height:60,  
                        rangeHi:"'.$hi.'",
                        style:"flip" }); </script></div>';
        }
        else if ($JamRunning)
        {
            $stmt = $connection->prepare("SELECT Title, ChosenTheme, EndTime FROM jams WHERE ID = ?;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            echo '<br><h3>The '.$rows[0]['Title'].' is now in progress!</h3>';
            echo '<br><h3>Get a move on it and base your game on "'.$rows[0]['ChosenTheme'].'"!</h3>';
            echo '<br><h3>Don'."'".'t forget the jam and all submissions will end on '.$rows[0]['EndTime'].'</h3>';
            $stmt = $connection->prepare("SELECT CountdownEnd FROM jams WHERE ID = ?;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            date_default_timezone_set('UTC');
            echo '<script src="countdown.js" type="text/javascript"></script>';
            $tm = strtotime($rows[0]['CountdownEnd']);
            $diff = $tm - time();
            $hi = "hour";
            if ($diff >= 86400) $hi = "day";
            echo '<div style="display: block; margin: 15px auto; width: 300px; height 60px;">
                  <script type="application/javascript">
                        var countdown = new Countdown({
                        time: '.$diff.',
                        width:240, 
                        height:60,  
                        rangeHi:"'.$hi.'",
                        style:"flip" }); </script></div>';
        }
        else if ($JamCompleted)
        {
            $stmt = $connection->prepare("SELECT Title FROM jams WHERE ID = ?;");
            $stmt->execute(array($ActiveJamID));
            $rows = $stmt->fetchAll();
            echo '<br><h3>The '.$rows[0]['Title'].' is now complete</h3>';
            echo '<br><h3>I hope you finished those games...</h3>';
            echo '<br><h3>Oh, and you better get those game submissions in!</h3>';
        }
    }
?>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>