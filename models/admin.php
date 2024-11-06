<?php
class Admin {
    private $conn;
    private $table_name = "admin";

    public $id_admin;
    public $nama;
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create method
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nama, username, password) VALUES (:nama, :username, :password)";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        
        // bind values
        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        
        return $stmt->execute();
    }

    // Read all method
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read one method
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_admin = :id_admin LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        // bind id_admin
        $stmt->bindParam(':id_admin', $this->id_admin);
        $stmt->execute();

        // fetch the data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->nama = $row['nama'];
            $this->username = $row['username'];
            $this->password = $row['password'];
        }
    }

    // Update method
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama = :nama, username = :username, password = :password WHERE id_admin = :id_admin";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        
        // bind values
        $stmt->bindParam(':id_admin', $this->id_admin);
        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        
        return $stmt->execute();
    }

    // Delete method
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_admin = :id_admin";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->id_admin = htmlspecialchars(strip_tags($this->id_admin));
        
        // bind id_admin
        $stmt->bindParam(':id_admin', $this->id_admin);
        
        return $stmt->execute();
    }
}
?>
