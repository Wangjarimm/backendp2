<?php
class Layanan {
    private $conn;
    private $table_name = "layanan";

    public $id_layanan;
    public $nama_layanan;
    public $jenis;
    public $harga;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create method
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nama_layanan, jenis, harga) VALUES (:nama_layanan, :jenis, :harga)";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->nama_layanan = htmlspecialchars(strip_tags($this->nama_layanan));
        $this->jenis = htmlspecialchars(strip_tags($this->jenis));
        $this->harga = htmlspecialchars(strip_tags($this->harga));
        
        // bind values
        $stmt->bindParam(':nama_layanan', $this->nama_layanan);
        $stmt->bindParam(':jenis', $this->jenis);
        $stmt->bindParam(':harga', $this->harga);
        
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_layanan = :id_layanan LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        // bind id_layanan
        $stmt->bindParam(':id_layanan', $this->id_layanan);
        $stmt->execute();

        // fetch the data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->nama_layanan = $row['nama_layanan'];
            $this->jenis = $row['jenis'];
            $this->harga = $row['harga'];
        }
    }

    // Update method
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_layanan = :nama_layanan, jenis = :jenis, harga = :harga WHERE id_layanan = :id_layanan";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->nama_layanan = htmlspecialchars(strip_tags($this->nama_layanan));
        $this->jenis = htmlspecialchars(strip_tags($this->jenis));
        $this->harga = htmlspecialchars(strip_tags($this->harga));
        
        // bind values
        $stmt->bindParam(':id_layanan', $this->id_layanan);
        $stmt->bindParam(':nama_layanan', $this->nama_layanan);
        $stmt->bindParam(':jenis', $this->jenis);
        $stmt->bindParam(':harga', $this->harga);
        
        return $stmt->execute();
    }

    // Delete method
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_layanan = :id_layanan";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->id_layanan = htmlspecialchars(strip_tags($this->id_layanan));
        
        // bind id_layanan
        $stmt->bindParam(':id_layanan', $this->id_layanan);
        
        return $stmt->execute();
    }
}
?>
