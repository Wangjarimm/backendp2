<?php
include_once 'models/pelanggan.php';

class PelangganController {
    private $db;           // Koneksi database
    private $pelanggan;     // Instance dari model Pelanggan

    public function __construct($dbConnection) {
        $this->db = $dbConnection; // Simpan koneksi ke dalam properti db
        $this->pelanggan = new Pelanggan($this->db); // Pass koneksi ke model Pelanggan
    }

    public function create($data) {
        $this->pelanggan->nama = $data['nama'];
        $this->pelanggan->jenis_kelamin = $data['jenis_kelamin'];
        $this->pelanggan->alamat = $data['alamat'];
        $this->pelanggan->no_telp = $data['no_telp'];

        if ($this->pelanggan->create()) {
            return json_encode(["message" => "Pelanggan berhasil ditambahkan."]);
        } else {
            return json_encode(["message" => "Gagal menambahkan pelanggan."]);
        }
    }

    public function readAll() {
        $stmt = $this->pelanggan->readAll();
        $pelanggans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($pelanggans);
    }

    public function readOne($id) {
        $this->pelanggan->id_pelanggan = $id;
        $this->pelanggan->readOne();
        return json_encode([
            "id_pelanggan" => $this->pelanggan->id_pelanggan,
            "nama" => $this->pelanggan->nama,
            "jenis_kelamin" => $this->pelanggan->jenis_kelamin,
            "alamat" => $this->pelanggan->alamat,
            "no_telp" => $this->pelanggan->no_telp
        ]);
    }

    public function update($id, $data) {
        $this->pelanggan->id_pelanggan = $id;
        $this->pelanggan->nama = $data['nama'];
        $this->pelanggan->jenis_kelamin = $data['jenis_kelamin'];
        $this->pelanggan->alamat = $data['alamat'];
        $this->pelanggan->no_telp = $data['no_telp'];

        if ($this->pelanggan->update()) {
            return json_encode(["message" => "Pelanggan berhasil diperbarui."]);
        } else {
            return json_encode(["message" => "Gagal memperbarui pelanggan."]);
        }
    }

    public function delete($id) {
        $this->pelanggan->id_pelanggan = $id;

        if ($this->pelanggan->delete()) {
            return json_encode(["message" => "Pelanggan berhasil dihapus."]);
        } else {
            return json_encode(["message" => "Gagal menghapus pelanggan."]);
        }
    }
}
?>
