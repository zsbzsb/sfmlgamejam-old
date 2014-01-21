<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>View Jams</h2>

<div id="form-container" style="width: 850px;">
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
        $dbaccess = new DBAccess();
        $mysqli = $dbaccess->CreateDBConnection();
        $stmt = $mysqli->prepare("SELECT ID, Title, BeginTime, EndTime, ChosenTheme FROM jams;");
        $stmt->execute();
        $stmt->bind_result($ID, $Title, $BeginTime, $EndTime, $ChosenTheme);
        echo '
            <div class="row">
                <span class="label" style="width: 35px; margin: 0px; color: orange;">ID</span>
                <span class="label" style="width: 175px; margin: 0px; color: orange;">Title</span>
                <span class="label" style="width: 175px; margin: 0px; color: orange;">Begin Time</span>
                <span class="label" style="width: 175px; margin: 0px; color: orange;">End Time</span>
                <span class="label" style="width: 185px; margin: 0px; color: orange;">Chosen Theme</span>
            </div>
            ';
        while ($stmt->fetch())
        {
            echo '
            <div class="row">
                <span class="label" style="width: 35px; margin: 0px;">'.$ID.'</span>
                <span class="label" style="width: 175px; margin: 0px;">'.$Title.'</span>
                <span class="label" style="width: 175px; margin: 0px;">'.$BeginTime.'</span>
                <span class="label" style="width: 175px; margin: 0px;">'.$EndTime.'</span>
                <span class="label" style="width: 185px; margin: 0px;">'.$ChosenTheme.'</span>
                <a class="link" href="/admin/editjam?id='.$ID.'&title='.$Title.'&begin='.$BeginTime.'&end='.$EndTime.'&chosen='.$ChosenTheme.'" style="float: right; margin-right: 10px;">Edit</a>
            </div>
            ';
        }
    ?>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>