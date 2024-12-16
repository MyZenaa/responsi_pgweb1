<?php
header('Content-Type: text/html; charset=UTF-8');

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "responsi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel 'wisata'
$sql = "SELECT latitude, longitude, wisata FROM wisata";
$result = $conn->query($sql);

$markers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $markers[] = [
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'nama_wisata' => $row['wisata']
        ];
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>KARSA</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <!-- Search CSS Library -->
    <link rel="stylesheet" href="asset/plugins/leaflet-search/leaflet-search.css" />
    <!-- Geolocation CSS Library for Plugin -->
    <link rel="stylesheet"
        href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.css" />
    <!-- Leaflet Mouse Position CSS Library -->
    <link rel="stylesheet" href="asset/plugins/leaflet-mouseposition/L.Control.MousePosition.css" />
    <!-- Leaflet Measure CSS Library -->
    <link rel="stylesheet" href="asset/plugins/leaflet-measure/leaflet-measure.css" />
    <!-- EasyPrint CSS Library -->
    <link rel="stylesheet" href="asset/plugins/leaflet-easyprint/easyPrint.css" />
    <!--Routing-->
    <link rel="stylesheet" href="asset/plugins/leaflet-routing/leaflet-routing-machine.css" />
    <!-- Marker Cluster -->
    <link rel="stylesheet" href="asset/plugins/leaflet-markercluster/MarkerCluster.css" />
    <link rel="stylesheet" href="asset/plugins/leaflet-markercluster/MarkerCluster.Default.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        /* Background pada Judul */
        .navbar-pink {
            background-color: #ff69b4;
            /* Warna pink */
            padding-top: 15px;
            padding-bottom: 0px;
            text-align: center;
            font-family: Helvetica bold;
            font-weight: 100;
            text-justify: inherit;
            padding-bottom: 15px;

        }

        .info {
            padding: 6px 8px;
            font: 14px/18px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            text-align: center;
        }

        .info h2 {
            margin: 0 0 5px;
            color: #777;
        }
    </style>

</head>

<body>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Search JavaScript Library -->
    <script src="assets/plugins/plugins/plugins/leaflet-search/leaflet-search.js"></script>
    <!-- Geolocation Javascript Library -->
    <script
        src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js"></script>
    <!-- Leaflet Mouse Position JavaScript Library -->
    <script src="asset/plugins/leaflet-mouseposition/L.Control.MousePosition.js"></script>
    <!-- Leaflet Measure JavaScript Library -->
    <script src="asset/plugins/leaflet-measure/leaflet-measure.js"></script>
    <!-- EasyPrint JavaScript Library -->
    <script src="asset/plugins/leaflet-easyprint/leaflet.easyPrint.js"></script>
    <!--Routing-->
    <script src="asset/plugins/leaflet-routing/leaflet-routing-machine.js"></script>
    <script src="asset/plugins/leaflet-routing/leaflet-routing-machine.min.js"></script>
    <!-- Marker Cluster -->
    <script src="asset/plugins/leaflet-markercluster/leaflet.markercluster.js"></script>
    <script src="asset/plugins/leaflet-markercluster/leaflet.markercluster-src.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <div id="map" style="height: 100vh;"></div>

    <script>
        /* Initial Map */
        var map = L.map('map').setView([-3.126552747020975, 115.1754562380905], 9); //lat, long, zoom
        /* Tile Basemap */
        var basemap1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> | <a href="Minarni Kukilo" target="_blank">Minarni Kukilo</a>' //menambahkan nama//
        });
        var basemap2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{ z } / { y } / { x }', {
            attribution: 'Tiles &copy; Esri | <a href="WebGIS of Ecokarta" target="_blank">Minarni Kukilo</a>'
        });
        var basemap3 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{ z } / { y } / { x }', {
            attribution: 'Tiles &copy; Esri | <a href="WebGIS of Ecokarta" target="_blank">Minarni Kukilo</a>'
        });
        var basemap4 = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptile s.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
        });
        basemap1.addTo(map);
        // Menambahkan layer WMS untuk Batas Administrasi Desa
        var wmsLayer1 = L.tileLayer.wms("http://localhost:8080/geoserver/wms", {
            layers: "PGWEB10:kalsel1",
            transparent: true,
            format: 'image/png',
            zIndex: 6 // Menambahkan z-index untuk memastikan di bawah layer lainnya
        }).addTo(map);

        // Menambahkan layer WMS untuk Provinsi Administrasi
        var wmsLayer2 = L.tileLayer.wms("https://geoservice.kalselprov.go.id/geoserver/BIROPEMOTDA/wms", {
            layers: "BIROPEMOTDA:PROVINSI_ADMINISTRASI_LN_50K",
            styles: "batas Admin  Kuning LN",
            transparent: true,
            format: 'image/png',
            srs: 'EPSG:4326',
            zIndex: 8 // Menambahkan z-index untuk memastikan tampil di atas layer lain
        }).addTo(map);

        /* Control Layer */
        var baseMaps = {
            "OpenStreetMap": basemap1,
            "Esri World Street": basemap2,
            "Esri Imagery": basemap3,
            "Stadia Dark Mode": basemap4
        };

        var overlayMaps = {
            "Batas Administrasi Kabupaten": wmsLayer1,
            "Jalan Provinsi": wmsLayer2, // Jalan Provinsi ditambahkan di atas data lainnya
        };

        L.control.layers(baseMaps, overlayMaps).addTo(map);

        /* Scale Bar */
        L.control.scale({
            maxWidth: 150,
            position: 'bottomright'
        }).addTo(map);

        /*Title*/
        var title = new L.Control();
        title.onAdd = function(map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };
        title.update = function() {
            this._div.innerHTML = 'WEBGIS PERSEBARAN WISATA  <br> WILAYAH KALIMANTAN SELATAN'
        };
        title.addTo(map);

        /* Image Legend */
        /* L.Control.Legend = L.Control.extend({
            onAdd: function (map) {
                var img = L.DomUtil.create('img');
                img.src = 'asset/pasar.jpg';
                img.style.width = '200px';
                return img;
            }
        });

        L.control.Legend = function (opts) {
            return new L.Control.Legend(opts);
        }

        L.control.Legend({ position: 'bottomleft' }).addTo(map); */


        // Tombol Home Custom Control
        var homeButton = L.Control.extend({
            options: {
                position: 'topleft' // Menempatkan di atas zoom in/zoom out
            },

            onAdd: function(map) {
                // Membuat elemen tombol
                var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');

                // Styling tombol
                container.style.backgroundColor = 'white';
                container.style.width = '30px';
                container.style.height = '30px';
                container.style.lineHeight = '30px';
                container.style.textAlign = 'center';
                container.style.cursor = 'pointer';

                // Tambahkan ikon atau teks ke tombol
                container.innerHTML = '<i class="fa fa-home"></i>'; // Ikon Home dari Font Awesome

                // Event klik untuk reset ke posisi awal
                container.onclick = function() {
                    window.location.href = 'index.html'; // Ganti dengan URL tujuan
                };

                return container;
            }
        });

        // Menambahkan tombol Home ke peta
        map.addControl(new homeButton());

        /* Image Watermark */
        L.Control.Watermark = L.Control.extend({
            onAdd: function(map) {
                var img = L.DomUtil.create('img');
                img.src = 'asset/logo.png';
                img.style.width = '100px';
                return img;
            }
        });

        L.control.watermark = function(opts) {
            return new L.Control.Watermark(opts);
        }

        L.control.watermark({
            position: 'bottomleft'
        }).addTo(map);

        /*Plugin Geolocation */
        var locateControl = L.control
            .locate({
                position: "topleft",
                drawCircle: true,
                follow: true,
                setView: true,
                keepCurrentZoomLevel: false,
                markerStyle: {
                    weight: 1,
                    opacity: 0.8,
                    fillOpacity: 0.8,
                },
                circleStyle: {
                    weight: 1,
                    clickable: false,
                },
                icon: "fas fa-crosshairs",
                metric: true,
                strings: {
                    title: "Click for Your Location",
                    popup: "You're here. Accuracy {distance} {unit}",
                    outsideMapBoundsMsg: "Not available",
                },
                locateOptions: {
                    maxZoom: 16,
                    watch: true,
                    enableHighAccuracy: true,
                    maximumAge: 10000,
                    timeout: 10000,
                },
            })
            .addTo(map);

        /*Plugin Mouse Position Coordinate */
        L.control.mousePosition({
            position: "bottomright",
            separator: ",",
            prefix: "Point Coodinate: "
        }).addTo(map);

        /*Plugin Measurement Tool */
        var measureControl = new L.Control.Measure({
            position: "topleft",
            primaryLengthUnit: "meters",
            secondaryLengthUnit: "kilometers",
            primaryAreaUnit: "hectares",
            secondaryAreaUnit: "sqmeters",
            activeColor: "#FF0000",
            completedColor: "#00FF00",
        });
        measureControl.addTo(map);

        /*Plugin EasyPrint */
        L.easyPrint({
            title: "Print",
        }).addTo(map);

        /*Plugin Routing*/
        L.Routing.control({
            waypoints: [
                L.latLng(-3.126552747020975, 115.1754562380905),
                L.latLng(-3.5324765742808673, 115.04999999999998)
            ],
            routeWhileDragging: true
        }).addTo(map);

        /* Layer Marker */
        var addressPoints = [
            [-3.290374204771886, 114.66060623926175, "Pasar Terapung Lok Baintan"],
            [-3.126552747020975, 115.1754562380905, "Goa Batu Hapu"],
            [-1.811538056610084, 115.62626079259627, "Goa Liang Tapah"],
            [-3.4991783675067505, 114.6846814843638, "Danau Bukit Perangon"],
            [-3.5324765742808673, 115.04999999999998, "Waduk Riam Kanan"],
            [-3.4342860338915493, 114.83357653766339, "Hutan Pinus Mentaos"],
            [-3.4686502800033305, 114.86617371685182, "Rumah Jomblo Banjar Baru"]
        ];

        var markers = L.markerClusterGroup();

        for (var i = 0; i < addressPoints.length; i++) {
            var a = addressPoints[i];
            var title1 = a[2];

            // Corrected marker initialization
            var marker = L.marker(new L.LatLng(a[0], a[1]), {
                title: title1
            });

            marker.bindPopup(title1);
            markers.addLayer(marker);
        }
        // Data dari PHP (dikirim sebagai JSON)
        var dataMarkers = <?php echo json_encode($markers); ?>;

        // Tambahkan marker ke peta berdasarkan data dari tabel 'wisata'
        dataMarkers.forEach(function(item) {
            var latitude = item.latitude;
            var longitude = item.longitude;
            var namaWisata = item.nama_wisata; // Ambil nama wisata dari database

            // Tambahkan marker ke peta dengan popup
            var marker = L.marker([latitude, longitude])
                .bindPopup(`<b>${namaWisata}</b>`);
            markers.addLayer(marker);
        });



        map.addLayer(markers);
    </script>

</body>

</html>