<?php

// routes/api.php

// Menyertakan file koneksi database
require_once 'config/database.php';

// Menyertakan semua controller
require_once 'controller/admincontroller.php'; 
require_once 'controller/pegawaicontroller.php'; 
require_once 'controller/pelanggancontroller.php'; 
require_once 'controller/layanancontroller.php'; 
require_once 'controller/transaksicontroller.php'; 

// Pastikan $dbConnection terdefinisi dengan benar
if (!isset($dbConnection)) {
    die(json_encode(["message" => "Database connection failed."]));
}

// Inisialisasi objek controller dengan koneksi database
$adminController = new AdminController($dbConnection);
$pegawaiController = new PegawaiController($dbConnection);
$pelangganController = new PelangganController($dbConnection);
$layananController = new LayananController($dbConnection);
$transaksiController = new TransaksiController($dbConnection);

// Menangani permintaan berdasarkan metode dan URL
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Mengambil data dari input
$inputData = json_decode(file_get_contents("php://input"), true);

// Fungsi untuk menangani permintaan CRUD secara umum dengan ID opsional
function handleRoutes($requestMethod, $controller, $inputData, $id = null) {
    switch ($requestMethod) {
        case 'POST':
            return $controller->create($inputData);
        case 'GET':
            if ($id) {
                return $controller->readOne($id);
            } else {
                return $controller->readAll();
            }
        case 'PUT':
            if ($id) {
                return $controller->update($id, $inputData);
            } else {
                return json_encode(["message" => "ID is required for update."]);
            }
        case 'DELETE':
            if ($id) {
                return $controller->delete($id);
            } else {
                return json_encode(["message" => "ID is required for delete."]);
            }
        default:
            header("HTTP/1.1 405 Method Not Allowed");
            return json_encode(["message" => "Method not allowed."]);
    }
}

// Mengarahkan permintaan ke rute yang sesuai
if (preg_match('/\/index\.php\/admin\/?(\d+)?/', $requestUri, $matches)) {
    $id = isset($matches[1]) ? $matches[1] : null;
    echo handleRoutes($requestMethod, $adminController, $inputData, $id);
} elseif (preg_match('/\/index\.php\/pegawai\/?(\d+)?/', $requestUri, $matches)) {
    $id = isset($matches[1]) ? $matches[1] : null;
    echo handleRoutes($requestMethod, $pegawaiController, $inputData, $id);
} elseif (preg_match('/\/index\.php\/pelanggan\/?(\d+)?/', $requestUri, $matches)) {
    $id = isset($matches[1]) ? $matches[1] : null;
    echo handleRoutes($requestMethod, $pelangganController, $inputData, $id);
} elseif (preg_match('/\/index\.php\/layanan\/?(\d+)?/', $requestUri, $matches)) {
    $id = isset($matches[1]) ? $matches[1] : null;
    echo handleRoutes($requestMethod, $layananController, $inputData, $id);
} elseif (preg_match('/\/index\.php\/transaksi\/?(\d+)?/', $requestUri, $matches)) {
    $id = isset($matches[1]) ? $matches[1] : null; // Ambil ID dari URL
    echo handleRoutes($requestMethod, $transaksiController, $inputData, $id);
}
 else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["message" => "Endpoint not found."]);
}
