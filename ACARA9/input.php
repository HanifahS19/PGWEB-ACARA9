<?php
// Konfigurasi MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penduduk_db2";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengecek jika data form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kecamatan'])) {
    // Ambil data dari form
    $kecamatan = $_POST['kecamatan'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];

    // Persiapan query menggunakan prepared statements
    $stmt = $conn->prepare("INSERT INTO penduduk (kecamatan, luas, jumlah_penduduk, longitude, latitude) VALUES (?, ?, ?, ?, ?)");
    
    // Bind parameter sesuai dengan tipe data
    $stmt->bind_param("sdiid", $kecamatan, $luas, $jumlah_penduduk, $longitude, $latitude);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Menutup statement
    $stmt->close();
}

$conn->close();
?>
