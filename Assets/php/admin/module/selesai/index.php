<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Selesai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
        }
        .btn-delete {
            color: white;
            background-color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Daftar Order Selesai</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nomor Meja</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Order</th>
                    <th>Total Order</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database
                $conn = new mysqli("localhost", "root", "", "db_toko");

                // Cek koneksi
                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                // Jika ada permintaan untuk menghapus data
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
                    $delete_id = $_POST['delete_id'];
                    $delete_sql = "DELETE FROM orders WHERE id = ?";
                    $stmt = $conn->prepare($delete_sql);
                    $stmt->bind_param("i", $delete_id);
                    if ($stmt->execute()) {
                        echo "<script>alert('Order berhasil dihapus.');</script>";
                    } else {
                        echo "<script>alert('Terjadi kesalahan saat menghapus data.');</script>";
                    }
                    $stmt->close();
                }

                // Query untuk mengambil data orders dengan status 'Selesai'
                $sql = "SELECT * FROM orders WHERE status = 'Selesai'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['table_number'] . "</td>";
                        echo "<td>" . $row['customer_name'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>" . $row['total_order'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo '<td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="' . $row['id'] . '">
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                              </td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data order yang selesai.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // JavaScript untuk mengonfirmasi penghapusan
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(event) {
                if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    event.preventDefault(); // Mencegah penghapusan jika dibatalkan
                }
            });
        });
    </script>
</body>
</html>
