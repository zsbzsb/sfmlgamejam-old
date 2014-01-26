<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn() || !$JamGalleryActive) header("location:/");
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
    $stmt = $connection->prepare("SELECT gm.Name, gm.Description, gm.Partner, gm.SourceLink, gm.ProjectLink, gm.LogoLink, gm.Screen1, gm.Screen2, gm.Screen3, gm.WindowsLink, gm.LinuxLink, gm.OSXLink, usr.Username FROM games AS gm JOIN users AS usr ON gm.UserID = usr.ID JOIN jams AS jm ON gm.JamID = jm.ID WHERE gm.ID = ? AND jm.GalleryOpen = 1;");
    $stmt->execute(array($_GET['id']));
    $rows = $stmt->fetchAll();
    if ($stmt->rowCount() == 0)
    {
        header("location:/");
        return;
    }
    // $rows[0]['']
    if ($rows[0]['LogoLink'] != "") echo '<img class="large-image" alt="" src="'.$rows[0]['LogoLink'].'" />';
    echo '<h2>'.$rows[0]['Name'].'</h2><br>';
    if ($rows[0]['Partner'] == "") echo '<h3>Developed by '.htmlspecialchars($rows[0]['Username']).'</h3>';
    else echo '<h3>Developed by '.htmlspecialchars($rows[0]['Username']).' and '.htmlspecialchars($rows[0]['Partner']).'</h3>';
    echo '<br>';
    if ($rows[0]['ProjectLink'] == "") echo '<div style="display: block; float: none; margin: auto; min-height: 1px; width: 800px; text-align: center;"><a class="link" target="_blank"  href="'.$rows[0]['SourceLink'].'">Source Link</a></div>';
    else echo '<div style="display: block; float: none; margin: auto; min-height: 1px; width: 800px; text-align: center;"><a class="link" target="_blank" href="'.$rows[0]['SourceLink'].'">Source Link</a>|<a class="link" target="_blank" href="'.$rows[0]['ProjectLink'].'">Project Link</a></div>';
    echo '<br>';
    echo '<div style="display: block; float: none; margin: auto; width: 500px; text-align: center;"><p>'.str_replace("\r\n", "<br>", htmlspecialchars(str_replace("<br>", "\r\n", $rows[0]['Description']))).'</p></div>';
    echo '<br>';
    echo '<div style="display: block; float: none; margin: auto; min-height: 1px; width: 800px; text-align: center;">';
    $needdel = false;
    if ($rows[0]['WindowsLink'] != "")
    {
        echo '<a class="link" target="_blank" href="'.$rows[0]['WindowsLink'].'">Windows Link</a>';
        $needdel = true;
    }
    if ($rows[0]['LinuxLink'] != "")
    {
        if ($needdel) echo '|';
        echo '<a class="link" target="_blank" href="'.$rows[0]['LinuxLink'].'">Linux Link</a>';
        $needdel = true;
    }
    if ($rows[0]['OSXLink'] != "")
    {
        if ($needdel) echo '|';
        echo '<a class="link" target="_blank" href="'.$rows[0]['OSXLink'].'">OS X Link</a>';
        $needdel = true;
    }
    echo '</div>';
    echo '<br>';
    echo '<div style="display: block; float: none; margin: auto; min-height: 1px; width: 800px; text-align: center;">';
    if ($rows[0]['Screen1'] != "")
    {
        echo '<a target="_blank" href="'.$rows[0]['Screen1'].'"><img class="small-image" alt="" style="display: inline-block; margin: 10px;" src="'.$rows[0]['Screen1'].'" /></a>';
    }
    if ($rows[0]['Screen2'] != "")
    {
        echo '<a target="_blank" href="'.$rows[0]['Screen2'].'"><img class="small-image" alt="" style="display: inline-block; margin: 10px;" src="'.$rows[0]['Screen2'].'" /></a>';
    }
    if ($rows[0]['Screen3'] != "")
    {
        echo '<a target="_blank" href="'.$rows[0]['Screen3'].'"><img class="small-image" alt="" style="display: inline-block; margin: 10px;" src="'.$rows[0]['Screen3'].'" /></a>';
    }
    echo '</div>'
?>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>