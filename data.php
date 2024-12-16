<?php
header('Content-Type: application/json'); // Set header JSON

// Koneksi ke database
$servername = "localhost"; // Server database
$username = "root"; // Username database
$password = ""; // Password database (kosong jika default)
$dbname = "responsi"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die(json_encode(['error' => 'Koneksi database gagal!'])); // Error jika koneksi gagal
}

// Query database untuk mengambil data
$sql = "SELECT latitude, longitude, wisata FROM wisata"; // Ganti 'lokasi' dengan nama tabel Anda
$result = $conn->query($sql);

$data = []; // Array untuk menampung data

// Looping data hasil query
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'wisata' => $row['wisata']
        ];
    }
}

// Tutup koneksi
$conn->close();

// Mengembalikan data dalam format JSON
echo json_encode($data);
?>