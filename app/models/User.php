<?php namespace App\Models;


class User extends Model
{
    public $table = 'users';

    public $hidden = ['password'];

}