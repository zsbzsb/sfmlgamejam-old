<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsAdmin()) header("location:/");
?>
<?php $selected = "admin"; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Administrator Functions</h2>

<div id="form-container">
    <div class="row"></div>
    <div class="row">
        <a class="link" href="/admin/addjam" style="margin-left: 10px;">Add Jam</a>
    </div>
    <div class="row">
        <a class="link" href="/admin/viewjams" style="margin-left: 10px;">View Jams</a>
    </div>
    <div class="row">
        <a class="link" href="/admin/viewusers" style="margin-left: 10px;">View Users</a>
    </div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>