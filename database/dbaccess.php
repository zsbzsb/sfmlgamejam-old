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
        $this->username = "root";
        $this->password = "zsbzsb";
        $this->database = "sfmlgamejam";
    }
    public function CreateDBConnection()
    {
        return new mysqli($this->host, $this->username, $this->password, $this->database);
    }
}
?>