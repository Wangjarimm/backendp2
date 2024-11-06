<?php
include_once 'models/layanan.php';

class LayananController {
    private $layanan;

    public function __construct($dbConnection) {
        $this->layanan = new Layanan($dbConnection);
    }

    public function create($data) {
        $this->layanan->nama_layanan = $data['nama_layanan'];
        $this->layanan->jenis = $data['jenis'];
        $this->layanan->harga = $data['harga'];

        if ($this->layanan->create()) {
            return json_encode(["message" => "Layanan berhasil ditambahkan."]);
        } else {
            return json_encode(["message" => "Gagal menambahkan layanan."]);
        }
    }

    public function readAll() {
        $stmt = $this->layanan->readAll();
        $layananData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($layananData);
    }

    public function readOne($id) {
        $this->layanan->id_layanan = $id;
        $this->layanan->readOne();
        
        return json_encode([
            "id_layanan" => $this->layanan->id_layanan,
            "nama_layanan" => $this->layanan->nama_layanan,
            "jenis" => $this->layanan->jenis,
            "harga" => $this->layanan->harga
        ]);
    }

    public function update($id, $data) {
        $this->layanan->id_layanan = $id;
        $this->layanan->nama_layanan = $data['nama_layanan'];
        $this->layanan->jenis = $data['jenis'];
        $this->layanan->harga = $data['harga'];

        if ($this->layanan->update()) {
            return json_encode(["message" => "Layanan berhasil diperbarui."]);
        } else {
            return json_encode(["message" => "Gagal memperbarui layanan."]);
        }
    }

    public function delete($id) {
        $this->layanan->id_layanan = $id;

        if ($this->layanan->delete()) {
            return json_encode(["message" => "Layanan berhasil dihapus."]);
        } else {
            return json_encode(["message" => "Gagal menghapus layanan."]);
        }
    }
}
?>
