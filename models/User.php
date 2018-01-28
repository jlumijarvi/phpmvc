<?php

namespace Models;

class User extends Model
{
    protected static $table = 'users';

    protected static $fields = [
        'id',
        'name'
    ];
}