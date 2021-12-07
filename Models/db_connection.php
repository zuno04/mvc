<?php
// Connexion à la base de données

// try {
//     $bdd = new PDO('mysql:host=localhost;dbname=djamin_exam_bd;charset=utf8', 'root', '');
// } catch(Exception $e) {
//     die('Erreur : '.$e->getMessage());
// }

class Database {
    public $connection;
    private static $instance;
    private $_host = 'localhost';
    private $_database = 'djamin_exam_bd';
    private $_username = 'root';
    private $_password = '';

  
    private function __construct() {
        try {
            $this->connection = new PDO('mysql:host='.$this->_host.';dbname='.$this->_database.';charset=utf8', $this->_username, $this->_password);
        } catch(Exception $e) {
            die('Erreur : '.$e->getMessage());
        }
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
  
}