<?php

namespace Models;

class User extends Model
{
    protected static $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }
}