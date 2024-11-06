<?php
include_once 'models/transaksi.php';

class TransaksiController {
    private $transaksi;

    public function __construct($dbConnection) {
        $this->transaksi = new Transaksi($dbConnection);
    }

    public function create($data) {
        $this->transaksi->id_pelanggan = $data['id_pelanggan'];
        $this->transaksi->id_pegawai = $data['id_pegawai'];
        $this->transaksi->id_layanan = $data['id_layanan'];
        $this->transaksi->tanggal_transaksi = $data['tanggal_transaksi'];

        if ($this->transaksi->create()) {
            return json_encode(["message" => "Transaksi berhasil ditambahkan."]);
        } else {
            return json_encode(["message" => "Gagal menambahkan transaksi."]);
        }
    }

    public function readAll() {
        $stmt = $this->transaksi->readAll();
        $transaksiData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($transaksiData);
    }

    public function readOne($id) {
        $this->transaksi->id_transaksi = $id;
        $this->transaksi->readOne();

        return json_encode([
            "id_transaksi" => $this->transaksi->id_transaksi,
            "id_pelanggan" => $this->transaksi->id_pelanggan,
            "id_pegawai" => $this->transaksi->id_pegawai,
            "id_layanan" => $this->transaksi->id_layanan,
            "tanggal_transaksi" => $this->transaksi->tanggal_transaksi
        ]);
    }

    public function update($id, $data) {
        // Validasi data input
        if (!is_array($data)) {
            return json_encode(["message" => "Invalid input data."]);
        }
    
        $requiredFields = ['id_pelanggan', 'id_pegawai', 'id_layanan', 'tanggal_transaksi'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return json_encode(["message" => "Missing field: $field"]);
            }
        }
    
        // Set ID transaksi dari URL
        $this->transaksi->id_transaksi = $id;
        $this->transaksi->id_pelanggan = $data['id_pelanggan'];
        $this->transaksi->id_pegawai = $data['id_pegawai'];
        $this->transaksi->id_layanan = $data['id_layanan'];
        $this->transaksi->tanggal_transaksi = $data['tanggal_transaksi'];
    
        if ($this->transaksi->update()) {
            return json_encode(["message" => "Transaksi berhasil diperbarui."]);
        } else {
            return json_encode(["message" => "Gagal memperbarui transaksi."]);
        }
    }
    

    public function delete($id) {
        $this->transaksi->id_transaksi = $id;

        if ($this->transaksi->delete()) {
            return json_encode(["message" => "Transaksi berhasil dihapus."]);
        } else {
            return json_encode(["message" => "Gagal menghapus transaksi."]);
        }
    }
}
?>
