<?php
class PreDO extends PDO {
    private $user = 'root';
    private $passwd = 'root';
    private $db_conn = 'mysql:host=localhost; dbname=dev_memes; charset=utf8mb4';
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    
    public function __construct() {
        try {
            $pdo = parent::__construct($this->db_conn, $this->user, $this->passwd, $this->options);
            
        // Catch PDOException and convert it to a regular Ex
        } catch (PDOException $ex) {
            throw new Excetion($ex);
        }
    }
}