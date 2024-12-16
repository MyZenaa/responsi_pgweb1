<?php
// Menghubungkan ke database
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "responsi"; 

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan 'no' yang akan dihapus melalui metode GET
if (isset($_GET['no'])) {
    $no = $_GET['no'];

    // Membuat query DELETE menggunakan prepared statement
    $sql = "DELETE FROM wisata WHERE no = ?";

    // Menyiapkan statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind parameter dengan tipe "i" (integer)
        $stmt->bind_param("i", $no);

        // Mengeksekusi statement
        if ($stmt->execute()) {
            echo "<script>
                    alert('Data berhasil dihapus!');
                    window.location.href='index.php';
                  </script>";
        } else {
            echo "Gagal menghapus data: " . $stmt->error;
        }

        // Menutup statement
        $stmt->close();
    } else {
        echo "Gagal menyiapkan statement: " . $conn->error;
    }
} else {
    echo "ID tidak ditemukan.";
}

// Menutup koneksi
$conn->close();
?>
