<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Add Jam</h2>

<div id="form-container">
    <form name="AddJamForm" method="post" action="/admin/addjam/doaddjam.php">
        <div class="row"></div>
        <div class="row">
            <span class="label">Title:</span>
            <input type="text" name="title" value="" class="textbox" />
        </div>
        <div class="row">
            <span class="label">Begin Time:</span>
            <input type="text" name="begintime" value="" class="textbox" />
        </div>
        <div class="row">
            <span class="label">End Time:</span>
            <input type="text" name="endtime" value="" class="textbox" />
        </div>
        <div class="row">
            <input type="submit" value="Create" class="button" />
        </div>
    </form>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>