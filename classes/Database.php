<?php 

class Database {

     private $host = "localhost";
     private $username = "root";
     private $password = "";  
     private $database = "shopping_website";

     private $conn;

     public function __construct() {
          $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
          if($this->conn->connect_error) {
               echo $this->conn->connect_error;
          }
     }

     public function getConnection() {
          return $this->conn;
     }

     
}