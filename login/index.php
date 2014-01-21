<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if ($session->GetIsLoggedIn()) header("location:/");
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<h2>Login</h2>

<div id="form-container">
    <form name="LoginForm" method="post" action="/scripts/dologin.php">
        <div class="row"></div>
        <div class="row">
            <h3 style="color: red;"><?php if (isset($_GET['error'])) echo htmlspecialchars($_GET['error']); ?><h3>
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
            <input type="submit" value="Login" class="button" />
        </div>
    </form>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>