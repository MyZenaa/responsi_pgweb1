# KARSA WebGIS

## Definisi
KARSA adalah WebGIS yang dibuat untuk memudahkan para wisatawan yang berkunjung ke Provinsi Kalimantan Selatan dan juga sebagai rekomendasi bagi para wisatawan yang ingin mengunjungi Wisata Alam yang ada di Kalimantan Selatan.

## Latar Belakang
Provinsi Kalimantan Selatan memiliki banyak destinasi wisata dan juga keanekaragaman wisata alam yang tersebar di seluruh provinsi Kalimantan Selatan. Keterbatasan akses maupun informasi dalam mengunjungi beberapa destinasi wisata yang ada memberikan solusi terkait pembuatan WebGIS persebaran destinasi wisata di Kalimantan Selatan.

## Tujuan Produk
- Memudahkan pencarian informasi mengenai data destinasi wisata.
- Meningkatkan promosi dan pemasaran wisata.
- Meningkatkan daya tarik wisatawan terhadap destinasi wisata.
- Mengembangkan teknologi dan kemajuan yang ada di Kalimantan Selatan.

## User Interface

### Landing Page
Landing page adalah halaman awal dari WebGIS KARSA yang berisikan beberapa komponen seperti:
- **About Us**
- **Wisata Alam**
- **Resources**

### WebGIS Persebaran
WebGIS ini berfungsi memvisualisasikan data yang diterima dari penambahan data wisata yang berisikan latitude dan longitude dari basis data.

### Basis Data
Berisikan halaman yang terhubung dengan database serta menjadi halaman yang bertugas untuk menampilkan data input yang telah dimasukkan.

## Alur Pembuatan
1. **Penentuan Tema**
2. **Pengambilan Data**
3. **Pembuatan Proyek**
4. **WebGIS KARSA**
5. **Koneksi Database**
6. **Penambahan Logika**

## Komponen Pembangun Produk
- **HTML**: Struktur utama halaman website.
- **CSS**: Untuk desain dan tata letak yang modern dan responsif.
- **Bootstrap**: Mempermudah pembuatan tampilan responsif di berbagai perangkat.
- **Javascript**: Untuk logika dan interaktivitas halaman.
- **Leaflet**: Menyediakan peta interaktif untuk memvisualisasikan data spasial.
- **Database**: Penyimpanan data destinasi wisata, latitude, dan longitude.
- **GeoServer**: Menyediakan layanan data spasial untuk peta.
- **Modal**: Digunakan untuk pengisian dan pengeditan data dalam bentuk pop-up.

## Basis Data yang Digunakan
| No  | Nama Kolom   | Tipe Data           |
| --- | ----------- | ------------------ |
| 1   | no          | int(11)            |
| 2   | wisata      | varchar(255)       |
| 3   | deskripsi   | varchar(255)       |
| 4   | latitude    | double             |
| 5   | longitude   | double             |

## Pengembang
**Praja Agung Kurniawan - 23/515553/SV/22572**

