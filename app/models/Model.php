<?php

namespace App\Models;


use Illuminate\Contracts\Support\Arrayable;

class Model implements Arrayable
{
    public $table;

    public $hidden = [];

    /** @var Database $database */
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }


    public static function all()
    {
        $model = (new static);

        return collect($model->database->all($model));
    }

    public static function find($id)
    {
        $model = (new static);

        return collect($model->database->find($model, $id));
    }

    public function getTable()
    {
        return $this->table;
    }

    public function toArray()
    {
        $data = get_object_vars($this);

        unset($data['table'], $data['database'], $data['hidden']);

        collect($this->hidden)->each(function ($field) use (&$data) {
            unset($data[$field]);
        });

        return $data;
    }
}