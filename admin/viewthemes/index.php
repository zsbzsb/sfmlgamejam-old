<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>View Themes - Jam: <?php echo $_GET['title']; ?></h2>

<div id="form-container" style="width: 850px">
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
        $dbaccess = new DBAccess();
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT thm.ID, thm.Theme, thm.TotalVotes, thm.CanVote, usr.Username FROM themes AS thm LEFT OUTER JOIN suggestions AS sug ON sug.ThemeID = thm.ID LEFT OUTER JOIN users AS usr ON usr.ID = sug.UserID WHERE thm.JamID = ?;");
        $stmt->execute(array($_GET['id']));
        $rows = $stmt->fetchAll();
        echo '
            <div class="row">
                <div class="column-header" style="width: 35px;">ID</div>
                <div class="column-header" style="width: 250px;">Theme</div>
                <div class="column-header" style="width: 175px;">Total Votes</div>
                <div class="column-header" style="width: 115px;">Can Vote</div>
                <div class="column-header" style="width: 175px;">User</div>
            </div>
            ';
        foreach ($rows as $row)
        {
            echo '
            <div class="row">
                <div class="column-value" style="width: 35px;">'.htmlspecialchars($row['ID']).'</div>
                <div class="column-value" style="width: 250px;">'.htmlspecialchars($row['Theme']).'</div>
                <div class="column-value" style="width: 175px;">'.htmlspecialchars($row['TotalVotes']).'</div>
                <div class="column-value" style="width: 115px;">'.htmlspecialchars($row['CanVote']).'</div>
                <div class="column-value" style="width: 175px;">'.htmlspecialchars($row['Username']).'</div>
                <a class="editlink" href="/admin/edittheme/?id='.$row['ID'].'&theme='.$row['Theme'].'&title='.$_GET['title'].'&jamid='.$_GET['id'].'&canvote='.$row['CanVote'].'">Edit</a>
            </div>
            ';
        }
    ?>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>