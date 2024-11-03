<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penduduk_db2";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM penduduk WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
    $stmt->close();
} else {
    echo "ID tidak valid.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Edit Data Penduduk</h2>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
        
        <label for="kecamatan">Kecamatan:</label><br>
        <input type="text" id="kecamatan" name="kecamatan" value="<?php echo htmlspecialchars($row['kecamatan']); ?>"><br>
        
        <label for="luas">Luas:</label><br>
        <input type="text" id="luas" name="luas" value="<?php echo htmlspecialchars($row['luas']); ?>"><br>
        
        <label for="jumlah_penduduk">Jumlah Penduduk:</label><br>
        <input type="text" id="jumlah_penduduk" name="jumlah_penduduk" value="<?php echo htmlspecialchars($row['jumlah_penduduk']); ?>"><br>
        
        <label for="longitude">Longitude:</label><br>
        <input type="text" id="longitude" name="longitude" value="<?php echo htmlspecialchars($row['longitude']); ?>"><br>
        
        <label for="latitude">Latitude:</label><br>
        <input type="text" id="latitude" name="latitude" value="<?php echo htmlspecialchars($row['latitude']); ?>"><br><br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>
