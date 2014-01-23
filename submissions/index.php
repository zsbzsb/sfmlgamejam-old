<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn() || !($AddGamesActive || $EditGamesActive)) header("location:/");
?>
<?php $selected = "submissions"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Game Submissions</h2>
<br>
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
    $session = new LoginSession();
    $dbaccess = new DBAccess();
    $userid = $session->GetUserID();
    $mysqli = $dbaccess->CreateDBConnection();
    $stmt = $mysqli->prepare("SELECT Name, Description, Partner, SourceLink, ProjectLink, LogoLink, Screen1, Screen2, Screen3, WindowsLink, LinuxLink, OSXLink FROM games WHERE JamID = ? AND UserID = ?;");
    $stmt->bind_param("ss", $ActiveJamID, $userid);
    $stmt->execute();
    $stmt->bind_result($Name, $Description, $Partner, $SourceLink, $ProjectLink, $LogoLink, $Screen1, $Screen2, $Screen3, $WindowsLink, $LinuxLink, $OSXLink);
    $cancel = false;
    if ($stmt->fetch())
    {
        if ($EditGamesActive)
        {
            echo '<h3>Edit Submission</h3>';
            $button = "Save";
        }
        else
        {
            echo '<h3>You have already submitted a game</h3>';
            $cancel = true;
        }
    }
    else
    {
        if ($AddGamesActive)
        {
            echo '<h3>Create Submission</h3>';
            $button = "Submit";
            $Name = "";
            $Description = "";
            $Partner = "";
            $SourceLink = "";
            $ProjectLink = "";
            $LogoLink = "";
            $Screen1 = "";
            $Screen2 = "";
            $Screen3 = "";
            $WindowsLink = "";
            $LinuxLink = "";
            $OSXLink = "";
        }
        else
        {
            echo '<h3>Submitting games is not currently open</h3>';
            $cancel = true;
        }
    }
    if (!$cancel)
    {
        if (isset($_GET['name'])) $Name = $_GET['name'];
        if (isset($_GET['descriptions'])) $Description = $_GET['description'];
        if (isset($_GET['partner'])) $Partner = $_GET['partner'];
        if (isset($_GET['sourcelink'])) $SourceLink = $_GET['sourcelink'];
        if (isset($_GET['projectlink'])) $ProjectLink = $_GET['projectlink'];
        if (isset($_GET['logolink'])) $LogoLink = $_GET['logolink'];
        if (isset($_GET['ss1'])) $Screen1 = $_GET['ss1'];
        if (isset($_GET['ss2'])) $Screen2 = $_GET['ss2'];
        if (isset($_GET['ss3'])) $Screen3 = $_GET['ss3'];
        if (isset($_GET['windows'])) $WindowsLink = $_GET['windows'];
        if (isset($_GET['linux'])) $LinuxLink = $_GET['linux'];
        if (isset($_GET['osx'])) $OSXLink = $_GET['osx'];
        $error = "";
        if (isset($_GET['error'])) $error = $_GET['error'];
        echo '
                <div id="form-container">
                    <form name="GameSubmissionForm" method="post" action="/submissions/dosubmit.php">
                        <div class="row"></div>
                        <div class="row">
                            <h3 style="color: red;">'.htmlspecialchars($error).'<h3>
                        </div>
                        <div class="row">
                            <span class="label">Name*:</span>
                            <input type="text" name="name" value="'.htmlspecialchars($Name).'" class="textbox" />
                        </div>
                        <div class="row">
                            <span class="label">Description*:</span>
                            <input type="text" name="description" value="'.htmlspecialchars($Description).'" class="textbox" />
                        </div>
                        <div class="row">
                            <span class="label">Partner:</span>
                            <input type="text" name="partner" value="'.htmlspecialchars($Partner).'" class="textbox" />
                        </div>
                        <div class="row">
                            <span class="label">Source Link*:</span>
                            <input type="text" name="sourcelink" value="'.htmlspecialchars($SourceLink).'" class="textbox" />
                        </div>
                        <div class="row">
                            <span class="label">Project Link:</span>
                            <input type="text" name="projectlink" value="'.htmlspecialchars($ProjectLink).'" class="textbox" />
                        </div>
                        <div class="row">
                            <span class="label">Logo Link:</span>
                            <input type="text" name="logolink" value="'.htmlspecialchars($LogoLink).'" class="textbox" />
                        </div>
                        <div class="row">
                            <span class="label">Sreenshot 1 Link*:</span>
                            <input type="text" name="ss1" value="'.htmlspecialchars($Screen1).'" class="textbox" />
                        </div>
                        <div class="row">
                            <span class="label">Sreenshot 2 Link:</span>
                            <input type="text" name="ss2" value="'.htmlspecialchars($Screen2).'" class="textbox" />
                        </div>
                        <div class="row">
                            <span class="label">Sreenshot 3 Link:</span>
                            <input type="text" name="ss3" value="'.htmlspecialchars($Screen3).'" class="textbox" />
                        </div>
                        <div class="row">
                            <span class="label">Windows Link:</span>
                            <input type="text" name="windows" value="'.htmlspecialchars($WindowsLink).'" class="textbox" />
                        </div>
                        <div class="row">
                            <span class="label">Linux Link:</span>
                            <input type="text" name="linux" value="'.htmlspecialchars($LinuxLink).'" class="textbox" />
                        </div>
                        <div class="row">
                            <span class="label">OS X Link:</span>
                            <input type="text" name="osx" value="'.htmlspecialchars($OSXLink).'" class="textbox" />
                        </div>
                        <div class="row">
                            <input type="submit" value="'.$button.'" class="button" />
                        </div>
                    </form>
                </div>
                <br><h4>No offensive/vulgar/inappropriate names</h4>
                <h4>*Required data</h4>
            ';
    }
?>
    

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
