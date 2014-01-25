<?php
class DBAccess
{
    private $host;
    private $username;
    private $password;
    private $database;
    public function __construct()
    {
        $this->host = "host";
        $this->username = "username";
        $this->password = "password";
        $this->database = "database";
    }
    public function CreateDBConnection()
    {
        return new PDO('mysql:host='.$this->host.';dbname='.$this->database.';charset=utf8', $this->username, $this->password, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
}
?>