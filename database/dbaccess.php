<?php
class DBAccess
{
    private $host;
    private $username;
    private $password;
    private $database;
    public function __construct()
    {
        $this->host = "localhost";
        $this->username = "username";
        $this->password = "password";
        $this->database = "database";
    }
    public function CreateDBConnection()
    {
        return new mysqli($this->host, $this->username, $this->password, $this->database);
    }
}
?>