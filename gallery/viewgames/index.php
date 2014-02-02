<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
$session = new LoginSession();
if (!$JamGalleryActive) header("location:/");
?>
<?php $selected = "gallery"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<?php
    if (!isset($_GET['id']))
    {
        header("location:/");
        return;
    }
    include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
    $dbaccess = new DBAccess();
    $connection = $dbaccess->CreateDBConnection();
    $stmt = $connection->prepare("SELECT Title FROM jams WHERE GalleryOpen = 1 AND ID = ?;");
    $stmt->execute(array($_GET['id']));
    $rows = $stmt->fetchAll();
    if ($stmt->rowCount() == 0)
    {
        header("location:/");
        return;
    }
    $title = $rows[0]['Title'];
    $stmt = $connection->prepare("SELECT gm.ID, gm.Name, gm.LogoLink, gm.Screen1, gm.Partner, usr.Username FROM games AS gm JOIN users AS usr ON gm.UserID = usr.ID WHERE gm.JamID = ? ORDER BY gm.Name ASC;");
    $stmt->execute(array($_GET['id']));
    $rows = $stmt->fetchAll();
    echo '<h2>View Games for the '.$title.'</h2>';
    echo '
        <div id="form-container" style="width: 890px;">
            <div class="row">
                <div class="column-header" style="width: 150px;">Logo</div>
                <div class="column-header" style="width: 200px;">Name</div>
                <div class="column-header" style="width: 200px;">Submitter</div>
                <div class="column-header" style="width: 200px;">Partner</div>
            </div>
        ';
    foreach ($rows as $row)
    {
        $img = $row['LogoLink'];
        if ($img == "") $img = $row['Screen1'];
        echo '
            <div class="row">
                <div class="column-value" style="width: 150px;"><a target="_blank" href="/gallery/viewgames/game/?id='.$row['ID'].'"><img alt="" src="'.$img.'" class="small-image" /></a></div>
                <div class="column-value" style="width: 200px;">'.htmlspecialchars($row['Name']).'</div>
                <div class="column-value" style="width: 200px;">'.htmlspecialchars($row['Username']).'</div>
                <div class="column-value" style="width: 200px;">'.htmlspecialchars($row['Partner']).'</div>
                <a class="editlink" target="_blank" href="/gallery/viewgames/game/?id='.$row['ID'].'">View Game</a>
            </div>
        ';
    }
    echo '
        </div>
        ';
?>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>