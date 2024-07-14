<?php
class DB {
      private $Host = 'localhost';
      private $Username = 'root';
      private $Password = '';
      private $Db_name = 'pdf_db';
      public $conn;
  
      public function __construct() {
          $this->connexion();
      }
  
      public function connexion(): mixed {
          try {
              $this->conn = new mysqli($this->Host, $this->Username, $this->Password, $this->Db_name);
          } catch (Exception $e) {
              return "Error: " . $e->getMessage();
          }
          return $this->conn;
      }

      public function connexionPdo(): mixed {
        try {
            $this->conn = new PDO("mysql:host={$this->Host};dbname={$this->Db_name}","{$this->Username}","{$this->Password}");
        } catch (PDOException $e) {
            return "Error";
        }
        return $this->conn;
    }
  }
  
?>
