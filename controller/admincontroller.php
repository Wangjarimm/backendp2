<?php
include_once 'models/admin.php';

class AdminController {
    private $db;      // Koneksi database
    private $admin;   // Instance dari model Admin

    public function __construct($dbConnection) {
        $this->db = $dbConnection; // Simpan koneksi ke dalam properti db
        $this->admin = new Admin($this->db); // Pass koneksi ke model Admin
    }

    public function create($data) {
        $this->admin->nama = $data['nama'];
        $this->admin->username = $data['username'];
        $this->admin->password = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($this->admin->create()) {
            return json_encode(["message" => "Admin berhasil ditambahkan."]);
        } else {
            return json_encode(["message" => "Gagal menambahkan admin."]);
        }
    }

    public function readAll() {
        $stmt = $this->admin->readAll();
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($admins);
    }

    public function readOne($id) {
        $this->admin->id_admin = $id;
        $this->admin->readOne();
        return json_encode([
            "id_admin" => $this->admin->id_admin,
            "nama" => $this->admin->nama,
            "username" => $this->admin->username
        ]);
    }

    public function update($id, $data) {
        $this->admin->id_admin = $id;
        $this->admin->nama = $data['nama'];
        $this->admin->username = $data['username'];
        $this->admin->password = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($this->admin->update()) {
            return json_encode(["message" => "Admin berhasil diperbarui."]);
        } else {
            return json_encode(["message" => "Gagal memperbarui admin."]);
        }
    }

    public function delete($id) {
        $this->admin->id_admin = $id;

        if ($this->admin->delete()) {
            return json_encode(["message" => "Admin berhasil dihapus."]);
        } else {
            return json_encode(["message" => "Gagal menghapus admin."]);
        }
    }
}
?>
