<?php
class Product {
     private $db;
 
     public function __construct($db) {
         $this->db = $db;
     }
 
     public function create($name, $description, $image, $price) {
         $name = $this->db->real_escape_string($name);
         $description = $this->db->real_escape_string($description);
         $image = $this->db->real_escape_string($image);
         $price = floatval($price);
 
         $sql = "INSERT INTO products (name, description, image, price) VALUES ('$name', '$description', '$image', $price)";
         return $this->db->query($sql);
     }
 
     public function read($id) {
          $id = intval($id);
          $sql = "SELECT * FROM products WHERE id = $id";
          $result = $this->db->query($sql);
          if ($result) {
              return $result->fetch_assoc();
          } else {
              error_log("Error reading product: " . $this->db->error);
              return null;
          }
      }
     public function update($id, $name, $description, $image, $price) {
         $id = intval($id);
         $name = $this->db->real_escape_string($name);
         $description = $this->db->real_escape_string($description);
         $price = floatval($price);

         if($image) {
             $image = $this->db->real_escape_string($image);
             $sql = "UPDATE products SET name = '$name', description = '$description', image = '$image', price = $price WHERE id = $id";
         } else {
             $sql = "UPDATE products SET name = '$name', description = '$description', price = $price WHERE id = $id";
         }
         
         return $this->db->query($sql);
     }
 
     public function delete($id) {
          $id = intval($id);

          $sql = "SELECT image FROM products WHERE id = $id";
          $result = $this->db->query($sql);
          $product = $result->fetch_assoc();

          if ($product && $product['image']) {
               $imagePath = '../images/' . $product['image'];

               if (file_exists($imagePath)) {
                    unlink($imagePath);
               }
          }
          $sql = "DELETE FROM products WHERE id = $id";
          return $this->db->query($sql);
     }
 
     public function getAll() {
         $sql = "SELECT * FROM products";
         $result = $this->db->query($sql);
         return $result->fetch_all(MYSQLI_ASSOC);
     }
 }