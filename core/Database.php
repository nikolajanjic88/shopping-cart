<?php

namespace app\core;
use PDO;

class Database {
    private $conn;
    private $stmt;

    public function __construct($host = DBHOST, $username = DBUSER, $password = DBPASSWORD, $dbname = DBNAME){
        $dsn = "mysql:host=$host;dbname=$dbname;";
        $this->conn = new PDO($dsn, $username, $password);
        $this->conn->exec("set names utf8");
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        if($this->conn);
    }

    public function query($query, $params = []) {
        $this->stmt = $this->conn->prepare($query);
        $this->stmt->execute($params);
        return $this;
    }

    public function get() {
        $result = $this->stmt->fetchAll();
        return $result;
    }

    public function find() {
        return $this->stmt->fetch();
    }

    public function findOrFail() {
        $result = $this->find();
        if(!$result) 
        {
            abort();
        } 
        else 
        {
            return $result;
        }
    }

    public function lastID() {
        return $this->conn->lastInsertId();
    }
}