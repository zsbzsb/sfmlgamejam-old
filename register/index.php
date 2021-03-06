<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if ($session->GetIsLoggedIn()) header("location:/");
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Register</h2>

<div id="form-container">
    <form name="RegisterForm" method="post" action="/scripts/doregister.php">
        <br>
        <div class="row">
            <h3 style="color: red;"><?php if (isset($_GET['error'])) echo htmlspecialchars($_GET['error']); ?></h3>
        </div>
        <div class="row">
            <span class="label">Username:</span>
            <input type="text" name="username" value="<?php if (isset($_GET['username'])) echo htmlspecialchars($_GET['username']); ?>" class="textbox" />
        </div>
        <div class="row">
            <span class="label">Password:</span>
            <input type="password" name="password" value="" class="textbox" />
        </div>
        <div class="row">
            <span class="label">Confirm Password:</span>
            <input type="password" name="confirmpassword" value="" class="textbox" />
        </div>
        <div class="row">
            <span class="label" style="font-size: 13px; margin-top: 6px;">I have read and accepted the <a class="link" target="_blank" href="/terms" style="font-size: 13px; margin: 0px; margin-top: 6px;">Terms of Use</a></span>
            <input type="submit" value="Register" class="button" />
        </div>
    </form>
</div>

<br><h4>No offensive/vulgar/inappropriate names</h4>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>