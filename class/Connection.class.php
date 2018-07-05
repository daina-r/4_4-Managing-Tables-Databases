<?php
abstract class Connection
{
    protected $dbType = 'mysql';
    protected $dbName = 'dmpronin';
    protected $user = 'dmpronin';
    protected $password = 'neto1740';

    public function getConnection()
    {
        $dbConnect = new PDO("$this->dbType:dbname=$this->dbName;host=localhost;charset=utf8", $this->user, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION])
        or die('Невозможно подключиться к базе данных');
        return $dbConnect;
    }

    public function getDBName()
    {
        return $this->dbName;
    }
}