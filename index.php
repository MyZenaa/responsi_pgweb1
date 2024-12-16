<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEB GIS - Data Wisata</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-p {
            background-color: #90afc5;
            /* Warna pink */
            padding-top: 15px;
            padding-bottom: 0px;
            text-align: center;
            overflow: hidden;
            font-family: Helvetica bold;
            font-weight: 100;
            text-justify: inherit;
            padding-bottom: 15px;

        }

        .content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            /* Pusatkan konten */
            padding: 20px;
            border: 2px solid  #90afc5;
            border-radius: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
            /* Jarak antara navbar dan konten */
        }

        .header-container {
            background-color:  #90afc5;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 40px;
            /* Menambahkan jarak lebih banyak */
        }

        th {
            background-color:  #90afc5;
            color: white;
        }

        .btn-sm {
            width: 80px;
            /* Tentukan lebar yang sama */
            text-align: center;
            
            /* Pusatkan teks */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-p fixed-top">
        <div class="container text-center">
            <img src="asset/logo.png" alt="" style="width: 100px;">
            <a class="navbar-brand" href="#home" style="color: aliceblue;">KARSA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.html" style="color: aliceblue;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html" style="color: aliceblue;">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html" style="color: aliceblue;">Wisata</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="map.php" style="color: aliceblue;">WebGIS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" style="color: aliceblue;">Tambah Wisata</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="header-container">
            <h1>WEB GIS</h1>
            <h3>DATA LOKASI WISATAN PROVINSI KALIMANTAN SELATAN</h3>
        </div>

        <!-- Tabel Data -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th style="text-align: center;">Wisata</th>
                    <th style="text-align: center;">Deskripsi</th>
                    <th style="text-align: center;">Latitude</th>
                    <th style="text-align: center;">Longitude</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database
                $conn = new mysqli("localhost", "root", "", "responsi");

                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                // Query untuk menampilkan data
                $sql = "SELECT * FROM wisata";
                $result = $conn->query($sql);

                $markers = []; // Array untuk menyimpan data marker

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row["no"] . "</td>
                            <td>" . $row["wisata"] . "</td>
                            <td>" . $row["deskripsi"] . "</td>
                            <td>" . $row["latitude"] . "</td>
                            <td>" . $row["longitude"] . "</td>
                            <td class='d-flex justify-content-center align-items-center'>
                                <a href='edit.php?no=" . $row["no"] . "' class='btn btn-sm btn-success'>Edit</a>
                                <a href='delete.php?no=" . $row["no"] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Delete</a>
                            </td>
                        </tr>";

                        // Tambahkan data ke array marker
                        $markers[] = [
                            'latitude' => $row["latitude"],
                            'longitude' => $row["longitude"],
                            'wisata' => $row["wisata"]
                        ];
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data ditemukan</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <!-- Tombol Input Data -->
        <div class="text-center mb-3">
            <a href="input.php" class="btn" style="background-color: #90afc5; color:#fff">Tambah Wisata Baru</a>
        </div>
    </div>
</body>

</html>