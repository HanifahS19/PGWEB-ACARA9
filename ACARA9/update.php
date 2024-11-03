<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penduduk_db2";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $kecamatan = $_POST['kecamatan'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];

    $sql = "UPDATE penduduk SET kecamatan = ?, luas = ?, jumlah_penduduk = ?, longitude = ?, latitude = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdiidi", $kecamatan, $luas, $jumlah_penduduk, $longitude, $latitude, $id);

    if ($stmt->execute()) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    header("Location: index.php"); // Redirect kembali ke halaman utama
    exit;
}

$conn->close();
?>
