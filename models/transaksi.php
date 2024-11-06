<?php
class Transaksi {
    private $conn;
    private $table_name = "transaksi";

    public $id_transaksi;
    public $id_pelanggan;
    public $id_pegawai;
    public $id_layanan;
    public $tanggal_transaksi;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create method
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (id_pelanggan, id_pegawai, id_layanan, tanggal_transaksi) VALUES (:id_pelanggan, :id_pegawai, :id_layanan, :tanggal_transaksi)";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->id_pelanggan = htmlspecialchars(strip_tags($this->id_pelanggan));
        $this->id_pegawai = htmlspecialchars(strip_tags($this->id_pegawai));
        $this->id_layanan = htmlspecialchars(strip_tags($this->id_layanan));
        $this->tanggal_transaksi = htmlspecialchars(strip_tags($this->tanggal_transaksi));
        
        // bind values
        $stmt->bindParam(':id_pelanggan', $this->id_pelanggan);
        $stmt->bindParam(':id_pegawai', $this->id_pegawai);
        $stmt->bindParam(':id_layanan', $this->id_layanan);
        $stmt->bindParam(':tanggal_transaksi', $this->tanggal_transaksi);
        
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_transaksi = :id_transaksi LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        // bind id_transaksi
        $stmt->bindParam(':id_transaksi', $this->id_transaksi);
        $stmt->execute();

        // fetch the data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id_pelanggan = $row['id_pelanggan'];
            $this->id_pegawai = $row['id_pegawai'];
            $this->id_layanan = $row['id_layanan'];
            $this->tanggal_transaksi = $row['tanggal_transaksi'];
        }
    }

    // Update method
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET id_pelanggan = :id_pelanggan, id_pegawai = :id_pegawai, id_layanan = :id_layanan, tanggal_transaksi = :tanggal_transaksi WHERE id_transaksi = :id_transaksi";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->id_pelanggan = htmlspecialchars(strip_tags($this->id_pelanggan));
        $this->id_pegawai = htmlspecialchars(strip_tags($this->id_pegawai));
        $this->id_layanan = htmlspecialchars(strip_tags($this->id_layanan));
        $this->tanggal_transaksi = htmlspecialchars(strip_tags($this->tanggal_transaksi));
        
        // bind values
        $stmt->bindParam(':id_transaksi', $this->id_transaksi);
        $stmt->bindParam(':id_pelanggan', $this->id_pelanggan);
        $stmt->bindParam(':id_pegawai', $this->id_pegawai);
        $stmt->bindParam(':id_layanan', $this->id_layanan);
        $stmt->bindParam(':tanggal_transaksi', $this->tanggal_transaksi);
        
        return $stmt->execute();
    }

    // Delete method
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_transaksi = :id_transaksi";
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->id_transaksi = htmlspecialchars(strip_tags($this->id_transaksi));
        
        // bind id_transaksi
        $stmt->bindParam(':id_transaksi', $this->id_transaksi);
        
        return $stmt->execute();
    }
}
?>
