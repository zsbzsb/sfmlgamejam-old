<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn() || !$JamGalleryActive) header("location:/");
?>
<?php $selected = "gallery"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Select Jam</h2>

<div id="form-container" style="width: 680px;">
    <div class="row">
        <div class="column-header" style="width: 215px;">Jam</div>
        <div class="column-header" style="width: 215px;">Theme</div>
    </div>
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
        include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
        $dbaccess = new DBAccess();
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT ID, Title, ChosenTheme FROM jams WHERE GalleryOpen = 1;");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        foreach ($rows as $row)
        {
            $active = "";
            if ($row['ID'] == $ActiveJamID) $active = "*";
            echo '
            <div class="row">
                <div class="column-value" style="width: 215px;">'.htmlspecialchars($row['Title'].$active).'</div>
                <div class="column-value" style="width: 215px;">'.htmlspecialchars($row['ChosenTheme'].$active).'</div>
                <a class="editlink" href="/gallery/viewgames/?id='.$row['ID'].'">View Games'.$active.'</a>
            </div>
            ';
        }
    ?>
</div>

<br><h4>*Current Jam</h4>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>