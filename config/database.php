<?php
class Database{

private $username = "root";
private $password = "";
private $host = "localhost";
private $database = "untouchable";


public function connect()
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->database ;
        $conn = new PDO($dsn, $this->username, $this->password);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}
