<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/scripts/loginsession.php';
$session = new LoginSession();
if (!$session->GetIsLoggedIn())
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);
    if ($username == "") header("location:/register/?error=Username cannot be blank");
    else if ($password == "") header("location:/register/?username=".$username."&error=Password cannot be blank");
    else if ($password != $confirmpassword) header("location:/register/?username=".$username."&error=The passwords do not match");
    else if ($session->TryRegister($username, $password))
    {
        header("location:/");
    }
    else
    {
        header("location:/register/?username=".$username."&error=Username is already in use");
    }
}
else
{
    header("location:/");
}
?>