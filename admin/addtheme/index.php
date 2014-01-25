<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Add Theme - Jam: <?php echo htmlspecialchars($_GET['title']); ?></h2>

<div id="form-container">
    <form name="AddThemeForm" method="post" action="/admin/addtheme/doaddtheme.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>" />
        <input type="hidden" name="title" value="<?php echo htmlspecialchars($_GET['title']); ?>" />
        <br>
        <div class="row">
            <span class="label">Theme:</span>
            <input type="text" name="theme" value="" class="textbox" />
        </div>
        <div class="row">
            <input type="submit" value="Create" class="button" />
        </div>
    </form>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>