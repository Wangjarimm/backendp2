<?php
class Pegawai {
    private $conn;
    private $table_name = "pegawai";

    public $id_pegawai;
    public $nama;
    public $ttl; // Tanggal lahir
    public $jenis_kelamin;
    public $alamat;
    public $no_telp;
    public $jobdesk;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create method
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nama, ttl, jenis_kelamin, alamat, no_telp, jobdesk) VALUES (:nama, :ttl, :jenis_kelamin, :alamat, :no_telp, :jobdesk)";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->ttl = htmlspecialchars(strip_tags($this->ttl));
        $this->jenis_kelamin = htmlspecialchars(strip_tags($this->jenis_kelamin));
        $this->alamat = htmlspecialchars(strip_tags($this->alamat));
        $this->no_telp = htmlspecialchars(strip_tags($this->no_telp));
        $this->jobdesk = htmlspecialchars(strip_tags($this->jobdesk));
        
        // bind values
        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':ttl', $this->ttl);
        $stmt->bindParam(':jenis_kelamin', $this->jenis_kelamin);
        $stmt->bindParam(':alamat', $this->alamat);
        $stmt->bindParam(':no_telp', $this->no_telp);
        $stmt->bindParam(':jobdesk', $this->jobdesk);
        
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_pegawai = :id_pegawai LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        // bind id_pegawai
        $stmt->bindParam(':id_pegawai', $this->id_pegawai);
        $stmt->execute();

        // fetch the data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->nama = $row['nama'];
            $this->ttl = $row['ttl'];
            $this->jenis_kelamin = $row['jenis_kelamin'];
            $this->alamat = $row['alamat'];
            $this->no_telp = $row['no_telp'];
            $this->jobdesk = $row['jobdesk'];
        }
    }

    // Update method
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama = :nama, ttl = :ttl, jenis_kelamin = :jenis_kelamin, alamat = :alamat, no_telp = :no_telp, jobdesk = :jobdesk WHERE id_pegawai = :id_pegawai";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->ttl = htmlspecialchars(strip_tags($this->ttl));
        $this->jenis_kelamin = htmlspecialchars(strip_tags($this->jenis_kelamin));
        $this->alamat = htmlspecialchars(strip_tags($this->alamat));
        $this->no_telp = htmlspecialchars(strip_tags($this->no_telp));
        $this->jobdesk = htmlspecialchars(strip_tags($this->jobdesk));
        
        // bind values
        $stmt->bindParam(':id_pegawai', $this->id_pegawai);
        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':ttl', $this->ttl);
        $stmt->bindParam(':jenis_kelamin', $this->jenis_kelamin);
        $stmt->bindParam(':alamat', $this->alamat);
        $stmt->bindParam(':no_telp', $this->no_telp);
        $stmt->bindParam(':jobdesk', $this->jobdesk);
        
        return $stmt->execute();
    }

    // Delete method
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_pegawai = :id_pegawai";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->id_pegawai = htmlspecialchars(strip_tags($this->id_pegawai));
        
        // bind id_pegawai
        $stmt->bindParam(':id_pegawai', $this->id_pegawai);
        
        return $stmt->execute();
    }
}
?>
