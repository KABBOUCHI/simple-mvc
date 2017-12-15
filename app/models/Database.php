<?php namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private $link = null;
    private $hostname = 'localhost';
    private $database = 'shell_fastlube';
    private $charset = 'utf8mb4';
    private $username = 'root';
    private $password = 'root';


    public function __construct()
    {
        try {
            $this->link = new PDO('mysql:host=' . $this->hostname . ';dbname=' . $this->database . ';charset=' . $this->charset, $this->username, $this->password);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function all(Model $model)
    {
        $stmt = $this->link->prepare("SELECT * from `{$model->getTable()}`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS,  get_class($model));
    }
    public function find(Model $model, $id)
    {
        $stmt = $this->link->prepare("SELECT * from `{$model->getTable()}` where id = :id limit 1");
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject( get_class($model));
    }

}

