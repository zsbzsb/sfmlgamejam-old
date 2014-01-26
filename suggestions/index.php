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
$connection = $dbaccess->CreateDBConnection();
$stmt = $connection->prepare("SELECT Title FROM jams WHERE ID = ?;");
$stmt->execute(array($ActiveJamID));
$rows = $stmt->fetchAll();
echo $rows[0]['Title'];
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
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT ThemeID FROM suggestions WHERE JamID = ? AND UserID = ?;");
        $userid = $session->GetUserID();
        $stmt->execute(array($ActiveJamID, $userid));
        $stmt->fetchAll();
        if ($stmt->rowCount() < $MaxSuggestions)
        {
            $error = "";
            if (isset($_GET['error'])) $error = $_GET['error'];
            $theme = "";
            if (isset($_GET['theme'])) $theme = $_GET['theme'];
            echo '
                <form name="AddSuggestionForm" method="post" action="/suggestions/doaddsuggestion.php">
                <br>
                <div class="row">
                    <h3 style="color: red;">'.$error.'<h3>
                </div>
                <div class="row">
                    <h3>'.$stmt->rowCount().'/'.$MaxSuggestions.' Suggestions</h3>
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
                <br>
                <div class="row">
                    <h3>You have finished your suggestions</h3>
                </div>
                <div class="row">
                    <h3>Please check back soon for voting!</h3>
                </div>
                <br>
                </div>
                ';
        }
    ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
