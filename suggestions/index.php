<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn() || !$ThemeSuggestionsOpen) header("location:/");
?>
<?php $selected = "suggestions"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Suggest Themes for the <?php
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
$dbaccess = new DBAccess();
$mysqli = $dbaccess->CreateDBConnection();
$stmt = $mysqli->prepare("SELECT Title FROM jams WHERE ID = ?;");
$stmt->bind_param("s", $ActiveJamID);
$stmt->execute();
$stmt->bind_result($Title);
$stmt->fetch();
echo $Title;
?></h2>

<?php
if (isset($_GET['suggested'])) echo "<br><h3>Thanks for suggesting '".htmlspecialchars($_GET['suggested'])."'</h3><br>";
?>

<div id="form-container">
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
        include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
        include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
        $session = new LoginSession();
        $dbaccess = new DBAccess();
        $mysqli = $dbaccess->CreateDBConnection();
        $stmt = $mysqli->prepare("SELECT ThemeID FROM suggestions WHERE JamID = ? AND UserID = ?;");
        $userid = $session->GetUserID();
        $stmt->bind_param("ss", $ActiveJamID, $userid);
        $stmt->execute();
        $stmt->bind_result($ThemeID);
        $count = 0;
        while ($stmt->fetch())
        {
            $count += 1;
        }
        if ($count < $MaxSuggestions)
        {
            $error = "";
            if (isset($_GET['error'])) $error = $_GET['error'];
            $theme = "";
            if (isset($_GET['theme'])) $theme = $_GET['theme'];
            echo '
                <form name="AddSuggestionForm" method="post" action="/suggestions/doaddsuggestion.php">
                <div class="row"></div>
                <div class="row">
                    <h3 style="color: red;">'.$error.'<h3>
                </div>
                <div class="row">
                    <h3>'.$count.'/'.$MaxSuggestions.' Suggestions</h3>
                </div>
                <div class="row">
                    <span class="label">Suggested Theme:</span>
                    <input type="text" name="theme" value="'.$theme.'" class="textbox" />
                </div>
                <div class="row">
                    <input type="submit" value="Suggest" class="button" />
                </div>
                </form>
                </div>
                <br><h4>No offensive/vulgar/inappropriate names</h4>
                ';
        }
        else
        {
                echo '
                <div class="row"></div>
                <div class="row">
                    <h3>You have finished your suggestions</h3>
                </div>
                <div class="row">
                    <h3>Please check back soon for voting!</h3>
                </div>
                <div class="row"></div>
                </div>
                ';
        }
    ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
