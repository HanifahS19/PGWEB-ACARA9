<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta dan Data Penduduk</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: #000000;
        }

        #map {
            height: 400px;
            width: 95%;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        table {
            width: 95%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba((102, 102, 153));
            max-width: 800px;
        }

        table,
        th,
        td {
            border: 1px solid #000000;
        }

        th {
            background-color: #a3a3c2;
            color: #ffffff;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        .btn-hapus,
        .btn-edit {
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            text-decoration: none;
        }

        .btn-hapus {
            background-color: #e57373;
        }

        .btn-hapus:hover {
            background-color: #ef5350;
        }

        .btn-edit {
            background-color: #4CAF50;
            margin-left: 5px;
        }

        .btn-edit:hover {
            background-color: #388E3C;
        }
    </style>
</head>

<body>
    

    <h2>Peta Lokasi Penduduk Wilayah Yogyakarta dan Sekitarnya</h2>
    <div id="map"></div>

    <h2>Data Penduduk</h2>
    <table>
        <tr>
            <th>Kecamatan</th>
            <th>Luas (km²)</th>
            <th>Jumlah Penduduk</th>
            <th>Longitude</th>
            <th>Latitude</th>
            <th>Aksi</th>
        </tr>

        <?php
        // Koneksi ke database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "penduduk_db2";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Cek koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Mengambil data dari database
        $sql = "SELECT id, kecamatan, luas, jumlah_penduduk, longitude, latitude FROM penduduk";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $markers = [];
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row["kecamatan"]) . "</td>
                    <td>" . htmlspecialchars($row["luas"]) . "</td>
                    <td>" . htmlspecialchars($row["jumlah_penduduk"]) . "</td>
                    <td>" . htmlspecialchars($row["longitude"]) . "</td>
                    <td>" . htmlspecialchars($row["latitude"]) . "</td>
                    <td>
                        <form method='post' action='delete.php' style='display:inline;'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                            <button type='submit' class='btn-hapus'>Hapus</button>
                        </form>
                        <form method='get' action='edit.php' style='display:inline;'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                            <button type='submit' class='btn-edit'>Update</button>
                        </form>
                    </td>
                </tr>";
                $markers[] = [
                    "kecamatan" => $row["kecamatan"],
                    "longitude" => $row["longitude"],
                    "latitude" => $row["latitude"],
                    "luas" => $row["luas"],
                    "jumlah_penduduk" => $row["jumlah_penduduk"],
                ];
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
        }

        $conn->close();
        ?>
    </table>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-7.75, 110.25], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var markers = <?php echo json_encode($markers); ?>;
        markers.forEach(function(marker) {
            L.marker([marker.latitude, marker.longitude]).addTo(map)
                .bindPopup("<b>Kecamatan: " + marker.kecamatan + "</b><br>Luas: " + marker.luas + " km²<br>Jumlah Penduduk: " + marker.jumlah_penduduk);
        });

        if (markers.length > 0) {
            var bounds = L.latLngBounds(markers.map(function(marker) {
                return [marker.latitude, marker.longitude];
            }));
            map.fitBounds(bounds);
        }
    </script>

</body>

</html>
