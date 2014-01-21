<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Edit Theme</h2>

<div id="form-container">
    <form name="EditThemeForm" method="post" action="/admin/edittheme/doedittheme.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>" />
        <input type="hidden" name="title" value="<?php echo htmlspecialchars($_GET['title']); ?>" />
        <input type="hidden" name="jamid" value="<?php echo htmlspecialchars($_GET['jamid']); ?>" />
        <div class="row"></div>
        <div class="row">
            <span class="label">Theme:</span>
            <input type="text" name="theme" value="<?php echo htmlspecialchars($_GET['theme']); ?>" class="textbox" />
        </div>
        <div class="row">
            <span class="label">Can Vote:</span>
            <input type="checkbox" name="canvote" class="checkbox" <?php if ($_GET['canvote'] == "1") echo 'checked'; ?> />
        </div>
        <div class="row">
            <input type="submit" value="Save" class="button" />
        </div>
    </form>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>