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
    function ProcessText($Text)
    {
        $txt = htmlspecialchars($Text);

        // Line breaks
        $txt = str_replace("[br]", "<br>", $txt);
//        $txt = str_replace("\r\n", "<br>", $txt);
//        $txt = str_replace("\n\r", "<br>", $txt);
//        $txt = str_replace("\r", "<br>", $txt);
//        $txt = str_replace("\n", "<br>", $txt);
        // Lists
        $txt = str_replace("[ul]", "<ul>", $txt);
        $txt = str_replace("[/ul]", "</ul>", $txt);
        $txt = str_replace("[ol]", "<ol>", $txt);
        $txt = str_replace("[/ol]", "</ol>", $txt);
        $txt = str_replace("[li]", "<li>", $txt);
        $txt = str_replace("[/li]", "</li>", $txt);
        // Links
        $txt = str_replace("[url=", "<a href=".'"', $txt);
        $txt = str_replace("[/url]", "</a>", $txt);
        // Alignment
        $txt = str_replace("[left]", "<div style=".'"'."text-align: left;".'"'.">", $txt);
        $txt = str_replace("[/left]", "</div>", $txt);
        $txt = str_replace("[right]", "<div style=".'"'."text-align: right;".'"'.">", $txt);
        $txt = str_replace("[/right]", "</div>", $txt);
        $txt = str_replace("[center]", "<div style=".'"'."text-align: center;".'"'.">", $txt);
        $txt = str_replace("[/center]", "</div>", $txt);
        // Cleanup
        $txt = str_replace("]", '"'.">", $txt);

        return $txt;
    }
    include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
    $session = new LoginSession();
    if ($session->GetIsAdmin()) echo '<h4><a class="link" target="_blank" style="font-size: 10px;" href="/admin/editgame/?id='.$_GET['id'].'">Admin Edit</a></h4>';
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
    if ($rows[0]['LogoLink'] != "") echo '<img class="large-image" alt="" src="'.$rows[0]['LogoLink'].'" />';
    echo '<h2>'.$rows[0]['Name'].'</h2><br>';
    if ($rows[0]['Partner'] == "") echo '<h3>Developed by '.htmlspecialchars($rows[0]['Username']).'</h3>';
    else echo '<h3>Developed by '.htmlspecialchars($rows[0]['Username']).' and '.htmlspecialchars($rows[0]['Partner']).'</h3>';
    echo '<br>';
    if ($rows[0]['ProjectLink'] == "") echo '<div style="display: block; float: none; margin: auto; min-height: 1px; width: 800px; text-align: center;"><a class="link" target="_blank"  href="'.$rows[0]['SourceLink'].'">Source Link</a></div>';
    else echo '<div style="display: block; float: none; margin: auto; min-height: 1px; width: 800px; text-align: center;"><a class="link" target="_blank" href="'.$rows[0]['SourceLink'].'">Source Link</a>|<a class="link" target="_blank" href="'.$rows[0]['ProjectLink'].'">Project Link</a></div>';
    echo '<br>';
    echo '<div class="text" style="display: block; float: none; margin: auto; width: 500px; text-align: left; font-size: 15px;"><p>'.ProcessText($rows[0]['Description']).'</p></div>';
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