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

// Mengambil data dari tabel meja
$sql = "SELECT table_number, costumer_name, order_date, total_order, status FROM meja";
$result = $conn->query($sql);

// Array untuk menyimpan status meja
$table_statuses = [];
$table_details = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $table_statuses[$row['table_number']] = $row['status'];
        $table_details[$row['table_number']] = $row;
    }
}

// Mengupdate status meja jika tombol Save ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['table_number'])) {
    $table_number = $_POST['table_number'];
    $costumer_name = $_POST['costumer_name'];
    $order_date = $_POST['order_date'];
    $total_order = $_POST['total_order'];
    $status = $_POST['status'];

    $sql_update = "INSERT INTO meja (table_number, costumer_name, order_date, total_order, status)
                   VALUES (?, ?, ?, ?, ?)
                   ON DUPLICATE KEY UPDATE
                   costumer_name=VALUES(costumer_name),
                   order_date=VALUES(order_date),
                   total_order=VALUES(total_order),
                   status=VALUES(status)";
    
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("issis", $table_number, $costumer_name, $order_date, $total_order, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Table status updated successfully.'); window.location.href = window.location.href;</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

// Menghapus data reservasi jika tombol Clear ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_table_number'])) {
    $table_number = $_POST['clear_table_number'];

    $sql_clear = "DELETE FROM meja WHERE table_number = ?";
    
    $stmt = $conn->prepare($sql_clear);
    $stmt->bind_param("i", $table_number);

    if ($stmt->execute()) {
        echo "<script>alert('Reservation cleared successfully.'); window.location.href = window.location.href;</script>";
    } else {
        echo "Error clearing reservation: " . $conn->error;
    }

    $stmt->close();
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation System</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 10px;
        }

        .grid button {
            width: 50px;
            height: 50px;
            border: none;
            color: white;
            font-size: 16px;
            margin: 5px;
            cursor: pointer;
        }

        .green {
            background-color: green;
        }

        .red {
            background-color: red;
        }

        .orange {
            background-color: orange;
        }

        .info {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }

        .info div {
            display: flex;
            align-items: center;
        }

        .info div span {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 5px;
            border: 1px solid black;
        }

        .info .green {
            background-color: green;
        }

        .info .red {
            background-color: red;
        }

        .info .orange {
            background-color: orange;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h1>CEK MEJA YANG TERSEDIA :</h1>
                <div class="grid" id="table-grid">
                    <?php
                    for ($i = 1; $i <= 24; $i++) {
                        $status = isset($table_statuses[$i]) ? $table_statuses[$i] : 'kosong';
                        $class = 'green'; // Default class

                        // Update class based on status
                        if ($status == 'direservasi') {
                            $class = 'orange';
                        } elseif ($status == 'diisi') {
                            $class = 'red';
                        }

                        echo "<button class='$class' data-table-number='$i'>$i</button>";
                    }
                    ?>
                </div>
                <div class="info">
                    <div><span class="green"></span> kosong</div>
                    <div><span class="red"></span> diisi</div>
                    <div><span class="orange"></span> reservasi</div>
                </div>
            </div>
            <div class="col-md-4">
                <h1>Reservation Details</h1>
                <form id="reservation-form" method="POST" action="">
                    <div class="form-group">
                        <label for="table-number">No Table:</label>
                        <input type="number" class="form-control" id="table-number" name="table_number" required>
                    </div>
                    <div class="form-group">
                        <label for="costumer-name">Costumer Name:</label>
                        <input type="text" class="form-control" id="costumer-name" name="costumer_name">
                    </div>
                    <div class="form-group">
                        <label for="order-date">Waktu Pesan:</label>
                        <input type="text" class="form-control" id="order-date" name="order_date" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="how-many-people">How Many people:</label>
                        <input type="number" class="form-control" id="how-many-people" name="total_order" min="1" value="1">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="kosong">Kosong</option>
                            <option value="direservasi">Direservasi</option>
                            <option value="diisi">Diisi</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success" id="save-button">Save</button>
                    <button type="button" class="btn btn-warning" id="clear-button">Clear</button>
                    <input type="hidden" id="clear-table-number" name="clear_table_number">
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#clear-button').click(function () {
                $('#clear-table-number').val($('#table-number').val());
                $('#reservation-form').submit();
            });

            $('#table-grid button').click(function () {
                var tableNumber = $(this).data('table-number');
                $('#table-number').val(tableNumber);

                // Load reservation details if exists
                var tableDetails = <?php echo json_encode($table_details); ?>;
                if (tableDetails[tableNumber]) {
                    $('#costumer-name').val(tableDetails[tableNumber].costumer_name);
                    $('#order-date').val(tableDetails[tableNumber].order_date);
                    $('#how-many-people').val(tableDetails[tableNumber].total_order);
                    $('#status').val(tableDetails[tableNumber].status);
                } else {
                    $('#reservation-form')[0].reset();
                    $('#table-number').val(tableNumber);
                    $('#order-date').val('<?php echo date('Y-m-d H:i:s'); ?>');
                }
            });
        });
    </script>
</body>
</html>
