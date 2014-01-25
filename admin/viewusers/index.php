<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>View Users</h2>

<div id="form-container">
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
        $dbaccess = new DBAccess();
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT ID, Username, IsAdmin FROM users;");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        echo '
            <div class="row">
                <div class="column-header" style="width: 35px;">ID</div>
                <div class="column-header" style="width: 250px;">Username</div>
                <div class="column-header" style="width: 115px;">Is Admin</div>
            </div>
            ';
        foreach ($rows as $row)
        {
            echo '
            <div class="row">
                <div class="column-value" style="width: 35px;">'.$row['ID'].'</div>
                <div class="column-value" style="width: 250px;">'.htmlspecialchars($row['Username']).'</div>
                <div class="column-value" style="width: 115px;">'.$row['IsAdmin'].'</div>
            </div>
            ';
        }
    ?>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>