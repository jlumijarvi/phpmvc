<?php

namespace Models;

abstract class Model
{
    protected static $table;

    protected static $fields = [];

    public function __construct()
    {
    }

    /**
     * @return \PDO
     */
    public static function createConnection()
    {
        $config = \App::instance()->getConfig('db');
        $host = $config['host'];
        $db = $config['db'];
        $user = $config['user'];
        $pass = $config['pass'];

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8;";
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new \PDO($dsn, $user, $pass, $opt);
    }

    /**
     * @param $name
     * @throws \Exception
     */
    public function __get($name)
    {
        if (!isset($this->name)) {
            throw new \Exception("Unknown field `$name`");
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (!isset($this->$name)) {
            $this->{$name} = $value;
        }
    }

    public function save()
    {
        
    }

    public function update()
    {
        $t = static::$table;

        $vars = get_object_vars($this);
        $id = $vars['id'];
        unset($vars['id']);

        $fields = [];
        $values = [];

        foreach ($vars as $field => $value) {
            if (in_array($field, static::$fields)) {
                $fields[] = "`$field` = ?";
                $values[] = $value;
            }
        }
        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE `$t` SET " . implode(',', $fields) . " WHERE id = ?;";

        $conn = Model::createConnection();

        $values[] = $id;

        return (bool)$conn->prepare($sql)->execute($values);
    }

    public static function findFirst($id)
    {
        $t = static::$table;
        $cls = get_called_class();

        $conn = Model::createConnection();
        $sql = "SELECT * FROM `$t` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        $ret = [];

        while ($row = $stmt->fetch()) {
            $user = new $cls;

            foreach ($row as $field => $value) {
                if (in_array($field, static::$fields)) {
                    $user->$field = $value;
                }
            }

            $ret[] = $user;
        }

        return reset($ret);
    }

    public static function find($params = [])
    {
        $t = static::$table;
        $cls = get_called_class();

        $conn = Model::createConnection();
        $sql = "SELECT * FROM `$t`";
        $stmt = $conn->query($sql);

        $ret = [];

        while ($row = $stmt->fetch()) {
            $user = new $cls;

            foreach ($row as $field => $value) {
                if (in_array($field, static::$fields)) {
                    $user->$field = $value;
                }
            }

            $ret[] = $user;
        }

        return $ret;
    }
}