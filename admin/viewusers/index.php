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
        $mysqli = $dbaccess->CreateDBConnection();
        $stmt = $mysqli->prepare("SELECT ID, Username, IsAdmin FROM users;");
        $stmt->execute();
        $stmt->bind_result($ID, $Username, $IsAdmin);
        echo '
            <div class="row">
                <span class="label" style="width: 35px; margin: 0px; color: orange;">ID</span>
                <span class="label" style="width: 250px; margin: 0px; color: orange;">Username</span>
                <span class="label" style="width: 115px; margin: 0px; color: orange;">Is Admin</span>
            </div>
            ';
        while ($stmt->fetch())
        {
            echo '
            <div class="row">
                <span class="label" style="width: 35px; margin: 0px;">'.$ID.'</span>
                <span class="label" style="width: 250px; margin: 0px;">'.$Username.'</span>
                <span class="label" style="width: 115px; margin: 0px;">'.$IsAdmin.'</span>
            </div>
            ';
        }
    ?>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>