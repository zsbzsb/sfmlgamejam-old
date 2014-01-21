<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn())
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if ($username == "") header("location:/login/?error=Username cannot be blank");
    else if ($password == "") header("location:/login/?username=".$username."&error=Password cannot be blank");
    else if ($session->TryLogin($username, $password))
    {
        header("location:/");
    }
    else
    {
        header("location:/login/?username=".$username."&error=Invalid Username or Password");
    }
}
else
{
    header("location:/");
}
?>