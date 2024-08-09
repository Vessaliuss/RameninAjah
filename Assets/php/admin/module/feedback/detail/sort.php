<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_toko";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menerapkan sorting
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

// Mengambil data dari tabel feedback dengan sorting
$sql = "SELECT id_feedback, name, email, message, satisfaction, terms_accepted, tgl_input FROM feedback ORDER BY satisfaction $sort_order";
$result = $conn->query($sql);

// Menampilkan data per baris
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_feedback"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["message"] . "</td>";
        echo "<td>" . $row["satisfaction"] . "</td>";
        echo "<td>" . ($row["terms_accepted"] ? "Yes" : "No") . "</td>";
        echo "<td>" . $row["tgl_input"] . "</td>";
        echo "<td>";
        echo "<form method='post' class='delete-form' data-id='" . $row["id_feedback"] . "' style='display:inline;'>";
        echo "<button type='submit' class='btn btn-danger btn-sm'>Clear</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No feedback found</td></tr>";
}

// Menutup koneksi
$conn->close();
?>
