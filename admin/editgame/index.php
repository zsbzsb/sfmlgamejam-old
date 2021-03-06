<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "submissions"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Edit Game</h2>
<br>
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
    $dbaccess = new DBAccess();
    $connection = $dbaccess->CreateDBConnection();
    $stmt = $connection->prepare("SELECT Name, Description, Partner, SourceLink, ProjectLink, LogoLink, Screen1, Screen2, Screen3, WindowsLink, LinuxLink, OSXLink FROM games WHERE ID = ?;");
    $stmt->execute(array($_GET['id']));
    $rows = $stmt->fetchAll();
    if ($stmt->rowCount() == 0)
    {
        header("location:/");
        return;
    }
    else
    {
        $Name = $rows[0]['Name'];
        $Description = $rows[0]['Description'];
        $Partner = $rows[0]['Partner'];
        $SourceLink = $rows[0]['SourceLink'];
        $ProjectLink = $rows[0]['ProjectLink'];
        $LogoLink = $rows[0]['LogoLink'];
        $Screen1 = $rows[0]['Screen1'];
        $Screen2 = $rows[0]['Screen2'];
        $Screen3 = $rows[0]['Screen3'];
        $WindowsLink = $rows[0]['WindowsLink'];
        $LinuxLink = $rows[0]['LinuxLink'];
        $OSXLink = $rows[0]['OSXLink'];
    }
    echo '
            <div id="form-container">
                <form name="GameSubmissionForm" method="post" action="/admin/editgame/doeditgame.php">
                    <input type="hidden" name="id" value="'.$_GET['id'].'" />
                    <br>
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
                        <input type="submit" value="Save" class="button" />
                    </div>
                </form>
            </div>
            <h4>*Required data</h4>
        ';
?>
    

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
