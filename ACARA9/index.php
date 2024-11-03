<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penduduk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        th {
            background-color: #007bff;
            color: #ffffff;
            padding: 15px;
        }

        td {
            padding: 15px;
            text-align: left;
            border: 1px solid #dddddd;
        }

        .button {
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            text-decoration: none;
        }

        .button-hapus {
            background-color: #e57373;
        }

        .button-hapus:hover {
            background-color: #ef5350;
        }

        .button-edit {
            background-color: #4CAF50;
            margin-left: 5px;
        }

        .button-edit:hover {
            background-color: #388E3C;
        }
    </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penduduk_db2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['delete_id']) && is_numeric($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM penduduk WHERE id = $id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<p>Data berhasil dihapus.</p>";
    } else {
        echo "<p>Error menghapus data: " . $conn->error . "</p>";
    }
}

$sql = "SELECT * FROM penduduk";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Kecamatan</th>
                <th>Luas (km²)</th>
                <th>Jumlah Penduduk</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Aksi</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["kecamatan"]) . "</td>
                <td>" . htmlspecialchars($row["luas"]) . "</td>
                <td>" . htmlspecialchars($row["jumlah_penduduk"]) . "</td>
                <td>" . htmlspecialchars($row["longitude"]) . "</td>
                <td>" . htmlspecialchars($row["latitude"]) . "</td>
                <td>
                    <form method='post' style='display:inline;' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>
                        <input type='hidden' name='delete_id' value='" . htmlspecialchars($row["id"]) . "'>
                        <button type='submit' class='button button-hapus'>Hapus</button>
                    </form>
                    <form method='get' action='edit.php' style='display:inline;'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                        <button type='submit' class='button button-edit'>Edit</button>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Tidak ada data</p>";
}

$conn->close();
?>

</body>
</html>
