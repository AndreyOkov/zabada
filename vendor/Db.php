<?php

namespace vendor;

use PDO;

class Db
{
    protected $pdo;

    protected static $instance;

    protected static $stmt;

    protected function __construct()
    {
        $db = require ROOT . '/config/config_db.php';
        try{
            $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function prepare($sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $this->stmt = $stmt;
    }

    public function fetch($sql)
    {
        // для команд SELECT
        return $this->pdo->query($sql)->fetch();
    }
    public function exec($sql)
    {
        // для команд INSERT, UPDATE
     
        return $this->pdo->exec($sql);
    }

    public function executeWithParams($sql, $args = []){
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    public function getLastId(){
        return $this->pdo->lastInsertId();
    }
} 