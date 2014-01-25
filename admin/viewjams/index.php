<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>View Jams</h2>

<div id="form-container" style="width: 1100px;">
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
        $dbaccess = new DBAccess();
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT ID, Title, BeginTime, EndTime, ChosenTheme, GalleryOpen FROM jams;");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        echo '
            <div class="row">
                <div class="column-header" style="width: 35px;">ID</div>
                <div class="column-header" style="width: 175px;">Title</div>
                <div class="column-header" style="width: 225px;">Begin Time</div>
                <div class="column-header" style="width: 225px;">End Time</div>
                <div class="column-header" style="width: 185px;">Chosen Theme</div>
                <div class="column-header" style="width: 175px;">Gallery Open</div>
            </div>
            ';
        foreach ($rows as $row)
        {
            echo '
            <div class="row">
                <div class="column-value" style="width: 35px;">'.$row['ID'].'</div>
                <div class="column-value" style="width: 175px;">'.htmlspecialchars($row['Title']).'</div>
                <div class="column-value" style="width: 225px;">'.htmlspecialchars($row['BeginTime']).'</div>
                <div class="column-value" style="width: 225px;">'.htmlspecialchars($row['EndTime']).'</div>
                <div class="column-value" style="width: 185px;">'.htmlspecialchars($row['ChosenTheme']).'</div>
                <div class="column-value" style="width: 175px;">'.$row['GalleryOpen'].'</div>
                <a class="editlink" href="/admin/editjam/?id='.$row['ID'].'&title='.$row['Title'].'&begin='.$row['BeginTime'].'&end='.$row['EndTime'].'&chosen='.$row['ChosenTheme'].'&gallery='.$row['GalleryOpen'].'">Edit</a>
            </div>
            ';
        }
    ?>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>