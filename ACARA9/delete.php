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

// Cek jika ada data yang ingin dihapus
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $sql = "DELETE FROM penduduk WHERE id = ?";
    
    // Persiapkan statement untuk keamanan
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Error menghapus data: " . $stmt->error;
    }
    
    // Menutup statement
    $stmt->close();
}

$conn->close();
header("Location: index.php");
exit;
?>
