<?php
class Pelanggan {
    private $conn;
    private $table_name = "pelanggan";

    public $id_pelanggan;
    public $nama;
    public $jenis_kelamin;
    public $alamat;
    public $no_telp;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create method
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nama, jenis_kelamin, alamat, no_telp) VALUES (:nama, :jenis_kelamin, :alamat, :no_telp)";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->jenis_kelamin = htmlspecialchars(strip_tags($this->jenis_kelamin));
        $this->alamat = htmlspecialchars(strip_tags($this->alamat));
        $this->no_telp = htmlspecialchars(strip_tags($this->no_telp));
        
        // bind values
        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':jenis_kelamin', $this->jenis_kelamin);
        $stmt->bindParam(':alamat', $this->alamat);
        $stmt->bindParam(':no_telp', $this->no_telp);
        
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_pelanggan = :id_pelanggan LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        // bind id_pelanggan
        $stmt->bindParam(':id_pelanggan', $this->id_pelanggan);
        $stmt->execute();

        // fetch the data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->nama = $row['nama'];
            $this->jenis_kelamin = $row['jenis_kelamin'];
            $this->alamat = $row['alamat'];
            $this->no_telp = $row['no_telp'];
        }
    }

    // Update method
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama = :nama, jenis_kelamin = :jenis_kelamin, alamat = :alamat, no_telp = :no_telp WHERE id_pelanggan = :id_pelanggan";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->jenis_kelamin = htmlspecialchars(strip_tags($this->jenis_kelamin));
        $this->alamat = htmlspecialchars(strip_tags($this->alamat));
        $this->no_telp = htmlspecialchars(strip_tags($this->no_telp));
        
        // bind values
        $stmt->bindParam(':id_pelanggan', $this->id_pelanggan);
        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':jenis_kelamin', $this->jenis_kelamin);
        $stmt->bindParam(':alamat', $this->alamat);
        $stmt->bindParam(':no_telp', $this->no_telp);
        
        return $stmt->execute();
    }

    // Delete method
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_pelanggan = :id_pelanggan";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->id_pelanggan = htmlspecialchars(strip_tags($this->id_pelanggan));
        
        // bind id_pelanggan
        $stmt->bindParam(':id_pelanggan', $this->id_pelanggan);
        
        return $stmt->execute();
    }
}
?>
