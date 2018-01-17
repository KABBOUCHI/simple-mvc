<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private $link = null;
    private $hostname;
    private $database;
    private $charset;
    private $username;
    private $password;
    private $port;

    public function __construct()
    {
        $this->hostname = config('database.host');
        $this->database = config('database.database');
        $this->username = config('database.username');
        $this->password = config('database.password');
        $this->charset = config('database.charset');
        $this->port = config('database.port');

        try {
            $this->link = new PDO('mysql:host='.$this->hostname.';port='.$this->port.';dbname='.$this->database.';charset='.$this->charset, $this->username, $this->password);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function all(Model $model)
    {
        $stmt = $this->link->prepare("SELECT * from `{$model->getTable()}`");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, get_class($model));
    }

    public function find(Model $model, $id)
    {
        $stmt = $this->link->prepare("SELECT * from `{$model->getTable()}` where id = :id limit 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchObject(get_class($model));
    }
}
