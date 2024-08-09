<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_toko";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memproses permintaan update status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql_update = "UPDATE orders SET status='selesai' WHERE id=?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Status pesanan telah diperbarui menjadi selesai.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Gagal memperbarui status pesanan.</div>';
    }
    $stmt->close();
}

// Query untuk mengambil data dari tabel orders
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Menyertakan Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .highlight {
            background-color: #d4edda;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Status Pesanan</h1>
        <h5 class="mb-4">tombol aksi 'selesai' hanya bisa digunakan ketika status pesanan siap diantarkan</h5>
        <?php
        if ($result->num_rows > 0) {
            // Pemberitahuan jika ada status siap diantarkan
            $ready_to_deliver = false;
            while($row = $result->fetch_assoc()) {
                if ($row["status"] == "siap diantarkan") {
                    $ready_to_deliver = true;
                    break;
                }
            }
            if ($ready_to_deliver) {
                echo '<div class="alert alert-success" role="alert">
                        Ada pesanan yang harus diantarkan!
                      </div>';
            }
            // Reset pointer hasil query
            $result->data_seek(0);
        ?>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Table Number</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Total Order</th>
                    <th>Status</th>
                    <th>Items Details</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Output data dari setiap baris
                while($row = $result->fetch_assoc()) {
                    $highlight_class = ($row["status"] == "siap diantarkan") ? "highlight" : "";
                    echo "<tr class='$highlight_class'>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["table_number"] . "</td>";
                    echo "<td>" . $row["customer_name"] . "</td>";
                    echo "<td>" . $row["order_date"] . "</td>";
                    echo "<td>" . $row["total_order"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td>" . $row["items_details"] . "</td>";
                    echo "<td>";
                    if ($row["status"] == "siap diantarkan") {
                        echo '<form method="post" action="" style="display:inline-block;">
                                <input type="hidden" name="id" value="' . $row["id"] . '">
                                <button type="submit" class="btn btn-success">Selesai</button>
                              </form>';
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
        <?php
        } else {
            echo '<div class="alert alert-warning" role="alert">
                    Tidak ada data.
                  </div>';
        }
        $conn->close();
        ?>
    </div>

    <!-- Menyertakan Bootstrap JS dan dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
