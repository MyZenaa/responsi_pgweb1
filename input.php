<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "responsi");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika form dikirim, proses data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $wisata = $_POST["wisata"];
    $deskripsi = $_POST["deskripsi"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];

    // Prepared statement untuk menambah data
    $stmt = $conn->prepare("INSERT INTO wisata (wisata, deskripsi, latitude, longitude) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdd", $wisata, $deskripsi, $latitude, $longitude);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Wisata</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 8px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2>Input Data Wisata</h2>
            <form action="input.php" method="POST" class="mt-4">
                <div class="form-group row mb-3">
                    <label for="wisata" class="col-sm-4 col-form-label">Nama Wisata:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="wisata" name="wisata" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="deskripsi" class="col-sm-4 col-form-label">Deskripsi:</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="latitude" class="col-sm-4 col-form-label">Latitude:</label>
                    <div class="col-sm-8">
                        <input type="number" step="any" class="form-control" id="latitude" name="latitude" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="longitude" class="col-sm-4 col-form-label">Longitude:</label>
                    <div class="col-sm-8">
                        <input type="number" step="any" class="form-control" id="longitude" name="longitude" required>
                    </div>
                </div>
                <br>
                <div class="btn-container mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin membatalkan?')">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
