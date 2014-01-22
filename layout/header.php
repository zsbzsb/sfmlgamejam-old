<html>
<head>
    <title>SFML Game Jam</title>
    <link rel="stylesheet" href="/css/main.css" type="text/css">
    <link rel="stylesheet" href="/css/form.css" type="text/css">
    <link rel="icon" type="image/png" href="/favicon.png" />
</head>
<body>
    <a href="/" style="text-decoration: none;"><h1>SFML Game Jam</h1></a>
    <?php if(!isset($selected)) $selected = ""; ?>
    <div id="sub-banner">
        <ul id="menu">
            <li>
                <a <?php if ($selected == "home") {echo 'class="selected"';} ?> href="/">Home</a>
            </li>
            <?php
            include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
            include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
            if ($ThemeSuggestionsActive)
            {
                echo '<li><a ';
                if ($selected == "suggestions") echo 'class="selected"';
                echo 'href="/suggestions">Theme Suggestions</a></li>';
            }
            if ($ThemeVotingActive)
            {
                echo '<li><a ';
                if ($selected == "voting") echo 'class="selected"';
                echo 'href="/voting">Theme Voting</a></li>';
            }
            if ($JamActive)
            {
                echo '<li><a ';
                if ($selected == "submissions") echo 'class="selected"';
                echo 'href="/submissions">Game Submissions</a></li>';
            }
            if ($NextJamActive)
            {
                echo '<li><a ';
                if ($selected == "upcoming") echo 'class="selected"';
                echo 'href="/upcoming">Upcoming Jam</a></li>';
            }
            if ($JamGallaryActive)
            {
                echo '<li><a ';
                if ($selected == "previous") echo 'class="selected"';
                echo 'href="/upcoming">Previous Jam</a></li>';
            }
            $session = new LoginSession();
            if ($session->GetIsAdmin())
            {
                echo '<li><a ';
                if ($selected == "admin") echo 'class="selected"';
                echo 'href="/admin">Admin</a></li>';
            }
            ?>
        </ul>
        <ul id="userbar">
            <?php
            include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
            $session = new LoginSession();
            if (!$session->GetIsLoggedIn())
            {
                echo '
                    <li>
                        <a href="/login">Login</a>
                    </li>
                    <li>
                        <a href="/register">Register</a>
                    </li>';
            }
            else
            {
                echo '
                    <li>
                        <a href="/">'.$session->GetUserName().'</a>
                    </li>
                    <li>
                        <a href="/logout">Logout</a>
                    </li>';
            }
            ?>
        </ul>
    </div>
    <div id="content">