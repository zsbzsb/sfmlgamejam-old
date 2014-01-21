<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>View Themes - Jam: <?php echo $_GET['title']; ?></h2>

<div id="form-container" style="width: 600px">
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
        $dbaccess = new DBAccess();
        $mysqli = $dbaccess->CreateDBConnection();
        $stmt = $mysqli->prepare("SELECT ID, Theme, TotalVotes, CanVote FROM themes WHERE JamID = ?;");
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $stmt->bind_result($ID, $Theme, $TotalVotes, $CanVote);
        echo '
            <div class="row">
                <span class="label" style="width: 35px; margin: 0px; color: orange;">ID</span>
                <span class="label" style="width: 175px; margin: 0px; color: orange;">Theme</span>
                <span class="label" style="width: 175px; margin: 0px; color: orange;">Total Votes</span>
                <span class="label" style="width: 115px; margin: 0px; color: orange;">Can Vote</span>
            </div>
            ';
        while ($stmt->fetch())
        {
            echo '
            <div class="row">
                <span class="label" style="width: 35px; margin: 0px;">'.$ID.'</span>
                <span class="label" style="width: 175px; margin: 0px;">'.$Theme.'</span>
                <span class="label" style="width: 175px; margin: 0px;">'.$TotalVotes.'</span>
                <span class="label" style="width: 115px; margin: 0px;">'.$CanVote.'</span>
                <a class="link" href="/admin/edittheme?id='.$ID.'&theme='.$Theme.'&title='.$_GET['title'].'&jamid='.$_GET['id'].'&canvote='.$CanVote.'" style="float: right; margin-right: 10px;">Edit</a>
            </div>
            ';
        }
    ?>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>