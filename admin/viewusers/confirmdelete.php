<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Confirm Delete for <?php echo $_GET['name']; ?></h2>

<script type="text/javascript">
    function ConfirmDelete(ID, Name)
    {
        var confirmation = confirm ("Are you sure you want to delete '" + Name + "'?");
        if (confirmation) window.location="/admin/viewusers/delete.php?id=" + ID;
    }
</script>

<div id="form-container">
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
    $dbaccess = new DBAccess();
    $connection = $dbaccess->CreateDBConnection();
    $stmt = $connection->prepare("SELECT ID FROM games WHERE UserID = ?;");
    $stmt->execute(array($_GET['id']));
    $stmt->fetchAll();
    $gamecount = $stmt->rowCount();
    $stmt = $connection->prepare("SELECT ID FROM suggestions WHERE UserID = ?;");
    $stmt->execute(array($_GET['id']));
    $stmt->fetchAll();
    $suggestioncount = $stmt->rowCount();
    $stmt = $connection->prepare("SELECT ID FROM votes WHERE UserID = ?;");
    $stmt->execute(array($_GET['id']));
    $stmt->fetchAll();
    $votecount = $stmt->rowCount();
    echo '<div class="row">
             <span class="label">Affected Games:</span>
             <span class="label" style="float: right; margin-left: 0px; margin-right: 15px;">'.$gamecount.'</span>
          </div>
          <div class="row">
             <span class="label">Affected Themes:</span>
             <span class="label" style="float: right; margin-left: 0px; margin-right: 15px;">'.$suggestioncount.'</span>
          </div>
          <div class="row">
             <span class="label">Affected Votes:</span>
             <span class="label" style="float: right; margin-left: 0px; margin-right: 15px;">'.$votecount.'</span>
          </div>
          <div class="row">
             <a class="editlink" href="javascript:ConfirmDelete(\''.$_GET['id'].'\',\''.$_GET['name'].'\');">Delete</a>
          </div>
        ';
?>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>