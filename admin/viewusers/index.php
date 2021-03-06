<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<script type="text/javascript">
    function ConfirmResetPW(ID, Name)
    {
        var confirmation = confirm ("Are you sure you want to reset the password for '" + Name + "'?");
        if (confirmation) window.location="/admin/viewusers/resetpw.php?id=" + ID;
    }
</script>

<h2>View Users</h2>

<div id="form-container" style="width: 1075px">
    <?php
        include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
        $dbaccess = new DBAccess();
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT ID, Username, LastIP, IsAdmin, IsBanned FROM users ORDER BY Username ASC;");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        echo '
            <div class="row">
                <div class="column-header" style="width: 35px;">ID</div>
                <div class="column-header" style="width: 250px;">Username</div>
                <div class="column-header" style="width: 225px;">Last IP</div>
                <div class="column-header" style="width: 115px;">Is Admin</div>
                <div class="column-header" style="width: 115px;">Is Banned</div>
            </div>
            ';
        foreach ($rows as $row)
        {
            echo '
            <div class="row">
                <div class="column-value" style="width: 35px;">'.$row['ID'].'</div>
                <div class="column-value" style="width: 250px;">'.htmlspecialchars($row['Username']).'</div>
                <div class="column-value" style="width: 225px;">'.$row['LastIP'].'</div>
                <div class="column-value" style="width: 115px;">'.$row['IsAdmin'].'</div>
                <div class="column-value" style="width: 115px;">'.$row['IsBanned'].'</div>
            ';
            echo '<a class="editlink" href="javascript:ConfirmResetPW(\''.$row['ID'].'\',\''.$row['Username'].'\');">Reset PW</a>';
            if ($row['IsBanned'] == 0) echo '<a class="editlink" href="/admin/viewusers/ban.php/?id='.$row['ID'].'&banned=1">Ban</a>';
            else echo '<a class="editlink" href="/admin/viewusers/ban.php/?id='.$row['ID'].'&banned=0">Unban</a>';
            echo '<a class="editlink" href="/admin/viewusers/confirmdelete.php/?id='.$row['ID'].'&name='.$row['Username'].'">Delete</a>';
            echo '
            </div>
            ';
        }
    ?>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>