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
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT ID FROM users WHERE Username = ?;");
        $stmt->execute(array($username));
        $stmt->fetchAll();
        if ($stmt->rowCount() > 0) return false;
        $stmt = $connection->prepare("INSERT INTO users (Username, Password, Salt, LastIP) VALUES (?, ?, ?, ?);");
        $Salt = uniqid('', true);;
        $stmt->execute(array($username, hash("SHA512", $Salt.$password.$Salt), $Salt), $_SERVER['REMOTE_ADDR']);
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $connection->lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['isadmin'] = false;
        return true;
    }
    public function TryLogin($username, $password)
    {
        $dbaccess = new DBAccess();
        $connection = $dbaccess->CreateDBConnection();
        $stmt = $connection->prepare("SELECT ID, IsAdmin, Password, Salt FROM users WHERE Username = ? AND IsBanned = 0;");
        $stmt->execute(array($username));
        $rows = $stmt->fetchAll();
        if ($stmt->rowCount() == 0) return false;
        if (hash("SHA512", $rows[0]['Salt'].$password.$rows[0]['Salt']) != $rows[0]['Password']) return false;
        if ($rows[0]['Salt'] == "")
        {
            $Salt = uniqid('', true);
            $stmt = $connection->prepare("UPDATE users SET Password = ?, Salt = ?, LastIP = ? WHERE Username = ?;");
            $stmt->execute(array(hash("SHA512", $Salt.$password.$Salt), $Salt, $_SERVER['REMOTE_ADDR'], $username));
        }
        else
        {
            $stmt = $connection->prepare("UPDATE users SET LastIP = ? WHERE Username = ?;");
            $stmt->execute(array($_SERVER['REMOTE_ADDR'], $username));
        }
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $rows[0]['ID'];
        $_SESSION['username'] = $username;
        $_SESSION['isadmin'] = $rows[0]['IsAdmin'] == 1;
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