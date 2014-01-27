<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/settings/settings.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn() || !$ThemeResultsVisible) header("location:/");
?>
<?php $selected = "results"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Theme Voting Results</h2>

<div id="form-container" style="width: 600px">
    <div class="row">
        <div class="column-header" style="width: 400px">Theme</div>
        <div class="column-header" style="width: 200px">Results</div>
    </div>
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
        $dbaccess = new DBAccess();
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT Theme, TotalVotes FROM themes WHERE JamID = ? AND CanVote = 1 ORDER BY TotalVotes DESC;");
        $stmt->execute(array($ActiveJamID));
        $rows = $stmt->fetchAll();
        $totalvotes = 0;
        foreach ($rows as $row)
        {
            $totalvotes += $row['TotalVotes'];
        }
        foreach ($rows as $row)
        {
            echo '
                <div class="row" style="border-top: 1px solid black;">
                    <div class="column-value" style="width: 400px">'.htmlspecialchars($row['Theme']).'</div>
                    <div class="column-value" style="width: 200px">'.$row['TotalVotes'].' - '.round((float)$row['TotalVotes'] / (float)$totalvotes * (float)100, 0).'%</div>
                </div>';
        }
    ?>
</div>
    
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
