<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';
class LoginSession
{
    public function __construct()
    {
        @session_start();
        if (!isset($_SESSION['loggedin']))
        {
            $_SESSION['loggedin'] = false;
        }
    }
    public function GetIsLoggedIn()
    {
        return $_SESSION['loggedin'];
    }
    public function GetUserID()
    {
        if (!$this->GetIsLoggedIn())
        {
            return -1;
        }
        else 
        {
            return $_SESSION['userid'];
        }
    }
    public function GetUsername()
    {
        if (!$this->GetIsLoggedIn())
        {
            return "";
        }
        else 
        {
            return $_SESSION['username'];
        }
    }
    public function GetIsAdmin()
    {
        if (!$this->GetIsLoggedIn()) return false;
        else
        {
            return $_SESSION['isadmin'];
        }
    }
    public function TryRegister($username, $password)
    {
        $dbaccess = new DBAccess();
        $mysqli = $dbaccess->CreateDBConnection();
        $stmt = $mysqli->prepare("SELECT ID FROM users WHERE Username = ?;");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->fetch()) return false;
        $stmt->close();
        $stmt = $mysqli->prepare("INSERT INTO users (Username, Password) VALUES (?, ?);");
        $stmt->bind_param("ss", $username, hash("SHA512", $password));
        $stmt->execute();
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $mysqli->insert_id;
        $_SESSION['username'] = $username;
        $_SESSION['isadmin'] = false;
        return true;
    }
    public function TryLogin($username, $password)
    {
        $dbaccess = new DBAccess();
        $mysqli = $dbaccess->CreateDBConnection();
        $stmt = $mysqli->prepare("SELECT ID, IsAdmin FROM users WHERE Username = ? AND Password = ?;");
        $stmt->bind_param("ss", $username, hash("SHA512", $password));
        $stmt->execute();
        $stmt->bind_result($ID, $IsAdmin);
        if (!$stmt->fetch()) return false;
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $ID;
        $_SESSION['username'] = $username;
        $_SESSION['isadmin'] = $IsAdmin == 1;
        return true;
    }
    public function Logout()
    {
        if ($this->GetIsLoggedIn())
        {
            $_SESSION['loggedin'] = false;
            unset($_SESSION['userid']);
            unset($_SESSION['username']);
            unset($_SESSION['isadmin']);
        }
    }
}
?>