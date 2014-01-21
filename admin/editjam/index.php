<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Edit Jam</h2>

<div id="form-container">
    <form name="EditJamForm" method="post" action="/admin/editjam/doeditjam.php">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
        <div class="row"></div>
        <div class="row">
            <a class="link" href="/admin/viewthemes?id=<?php echo $_GET['id']; ?>&title=<?php echo $_GET['title']; ?>" style="margin-left: 10px;">View Themes</a>
            <a class="link" href="/admin/addtheme?id=<?php echo $_GET['id']; ?>&title=<?php echo $_GET['title']; ?>" style="margin-left: 10px;">Add Theme</a>
        </div>
        <div class="row">
            <span class="label">Title:</span>
            <input type="text" name="title" value="<?php echo $_GET['title']; ?>" class="textbox" />
        </div>
        <div class="row">
            <span class="label">Begin Time:</span>
            <input type="text" name="begintime" value="<?php echo $_GET['begin']; ?>" class="textbox" />
        </div>
        <div class="row">
            <span class="label">End Time:</span>
            <input type="text" name="endtime" value="<?php echo $_GET['end']; ?>" class="textbox" />
        </div>
        <div class="row">
            <span class="label">Chosen Theme:</span>
            <input type="text" name="chosentheme" value="<?php echo $_GET['chosen']; ?>" class="textbox" />
        </div>
        <div class="row">
            <input type="submit" value="Save" class="button" />
        </div>
    </form>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>