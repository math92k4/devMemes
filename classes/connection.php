<?php
class DB extends PDO {
    
    public function __construct() {
        $dsn = 'mysql:host=localhost; dbname=dev_memes; charset=utf8mb4';
        $user = 'root';
        $passwd = 'root';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            parent::__construct($dsn, $user, $passwd, $options);

        } catch (PDOException $ex) {
            echo 'Connection error';
            exit();
        }
    }

    public function disconnect($con) {
        $con = null;
    }
}