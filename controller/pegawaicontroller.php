<?php
include_once 'models/pegawai.php';

class PegawaiController {
    private $db;      // Koneksi database
    private $pegawai; // Instance dari model Pegawai

    public function __construct($dbConnection) {
        $this->db = $dbConnection; // Simpan koneksi ke dalam properti db
        $this->pegawai = new Pegawai($this->db); // Pass koneksi ke model Pegawai
    }

    public function create($data) {
        $this->pegawai->nama = $data['nama'];
        $this->pegawai->ttl = $data['ttl'];
        $this->pegawai->jenis_kelamin = $data['jenis_kelamin'];
        $this->pegawai->alamat = $data['alamat'];
        $this->pegawai->no_telp = $data['no_telp'];
        $this->pegawai->jobdesk = $data['jobdesk'];

        if ($this->pegawai->create()) {
            return json_encode(["message" => "Pegawai berhasil ditambahkan."]);
        } else {
            return json_encode(["message" => "Gagal menambahkan pegawai."]);
        }
    }

    public function readAll() {
        $stmt = $this->pegawai->readAll();
        $pegawais = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($pegawais);
    }

    public function readOne($id) {
        $this->pegawai->id_pegawai = $id;
        $this->pegawai->readOne();
        return json_encode([
            "id_pegawai" => $this->pegawai->id_pegawai,
            "nama" => $this->pegawai->nama,
            "ttl" => $this->pegawai->ttl,
            "jenis_kelamin" => $this->pegawai->jenis_kelamin,
            "alamat" => $this->pegawai->alamat,
            "no_telp" => $this->pegawai->no_telp,
            "jobdesk" => $this->pegawai->jobdesk
        ]);
    }

    public function update($id, $data) {
        $this->pegawai->id_pegawai = $id;
        $this->pegawai->nama = $data['nama'];
        $this->pegawai->ttl = $data['ttl'];
        $this->pegawai->jenis_kelamin = $data['jenis_kelamin'];
        $this->pegawai->alamat = $data['alamat'];
        $this->pegawai->no_telp = $data['no_telp'];
        $this->pegawai->jobdesk = $data['jobdesk'];

        if ($this->pegawai->update()) {
            return json_encode(["message" => "Pegawai berhasil diperbarui."]);
        } else {
            return json_encode(["message" => "Gagal memperbarui pegawai."]);
        }
    }

    public function delete($id) {
        $this->pegawai->id_pegawai = $id;

        if ($this->pegawai->delete()) {
            return json_encode(["message" => "Pegawai berhasil dihapus."]);
        } else {
            return json_encode(["message" => "Gagal menghapus pegawai."]);
        }
    }
}
?>
