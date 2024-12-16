<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "responsi");

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah ID telah diterima melalui URL
if (isset($_GET['no'])) {
    $no = $_GET['no'];

    // Query untuk mengambil data berdasarkan ID
    $sql = "SELECT * FROM wisata WHERE no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Ambil data
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
    $stmt->close();
} else {
    echo "ID tidak valid.";
    exit;
}

// Memproses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $wisata = $_POST['wisata'];
    $deskripsi = $_POST['deskripsi'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Query untuk memperbarui data
    $update_sql = "UPDATE wisata SET 
            wisata = ?, 
            deskripsi = ?, 
            latitude = ?, 
            longitude = ?
            WHERE no = ?";

    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssddi", $wisata, $deskripsi, $latitude, $longitude, $no);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data berhasil diperbarui.');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Wisata</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        label {
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Edit Data Wisata</h2>
            <form method="POST" action="">
                <div class="form-group row mb-3">
                    <label for="wisata" class="col-sm-4 col-form-label">Nama Wisata</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="wisata" name="wisata" value="<?php echo htmlspecialchars($row['wisata']); ?>" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="deskripsi" class="col-sm-4 col-form-label">Deskripsi</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo htmlspecialchars($row['deskripsi']); ?></textarea>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="latitude" class="col-sm-4 col-form-label">Latitude</label>
                    <div class="col-sm-8">
                        <input type="number" step="any" class="form-control" id="latitude" name="latitude" value="<?php echo $row['latitude']; ?>" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="longitude" class="col-sm-4 col-form-label">Longitude</label>
                    <div class="col-sm-8">
                        <input type="number" step="any" class="form-control" id="longitude" name="longitude" value="<?php echo $row['longitude']; ?>" required>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>
