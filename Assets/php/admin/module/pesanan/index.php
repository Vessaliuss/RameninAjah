<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_toko";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle status update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update_status_sql = "UPDATE orders SET status = '$status' WHERE id = '$order_id'";
    if ($conn->query($update_status_sql) === TRUE) {
        echo json_encode(["message" => "Order status updated successfully.", "status" => $status]);
    } else {
        echo json_encode(["message" => "Error updating order status: " . $conn->error]);
    }
    exit;
}

// Handle order clearing
if (isset($_POST['clear_order'])) {
    $order_id = $_POST['order_id'];

    $delete_order_items_sql = "DELETE FROM order_items WHERE order_id = '$order_id'";
    if ($conn->query($delete_order_items_sql) === TRUE) {
        $delete_order_sql = "DELETE FROM orders WHERE id = '$order_id'";
        if ($conn->query($delete_order_sql) === TRUE) {
            echo json_encode(["message" => "Order cleared successfully."]);
        } else {
            echo json_encode(["message" => "Error clearing order: " . $conn->error]);
        }
    } else {
        echo json_encode(["message" => "Error clearing order items: " . $conn->error]);
    }
    exit;
}

// Fetch order data
$sql = "SELECT id, table_number, customer_name, order_date, total_order, status, items_details FROM orders";
$result = $conn->query($sql);

$new_order_sql = "SELECT * FROM orders WHERE status = 'menunggu' ORDER BY order_date DESC LIMIT 1";
$new_order_result = $conn->query($new_order_sql);
$new_order = $new_order_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>Order List</title>
    <style>
        .order-container {
            display: flex;
        }
        .order-table {
            width: 75%;
            margin-right: 20px;
        }
        .incoming-order {
            width: 25%;
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .status-select {
            width: 100%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order List</h1>
        <h5>Ketika melalkukan update pada status harap lakukan refresh page!</h5>
        <div class="order-container">
            <div class="order-table">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Table</th>
                            <th>Customer Name</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Items Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr id='order-" . $row["id"] . "'>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["table_number"] . "</td>";
                                echo "<td>" . $row["customer_name"] . "</td>";
                                echo "<td>" . $row["order_date"] . "</td>";
                                echo "<td class='status'>" . $row["status"] . "</td>";
                                echo "<td>" . $row["items_details"] . "</td>";
                                echo "<td>
                                        <button type='button' class='btn btn-danger clear-btn' data-id='" . $row["id"] . "'>Clear</button>
                                        <select class='form-select status-select' data-id='" . $row["id"] . "'>
                                            <option value='menunggu' " . ($row["status"] == 'menunggu' ? 'selected' : '') . ">Menunggu</option>
                                            <option value='proses' " . ($row["status"] == 'proses' ? 'selected' : '') . ">Proses</option>
                                            <option value='siap diantarkan' " . ($row["status"] == 'siap diantarkan' ? 'selected' : '') . ">Siap Diantarkan</option>
                                            <option value='selesai' " . ($row["status"] == 'selesai' ? 'selected' : '') . ">Selesai</option>
                                        </select>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No orders available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="incoming-order">
                <h4>Pesanan Masuk <span class="badge bg-danger">1</span></h4>
                <?php if ($new_order): ?>
                    <p>No Table: <?php echo $new_order['table_number']; ?></p>
                    <p>Waktu Pesan: <?php echo $new_order['order_date']; ?></p>
                    <p>Total Order: Rp. <?php echo number_format($new_order['total_order'], 0, ',', '.'); ?></p>
                <?php else: ?>
                    <p>No new orders</p>
                <?php endif; ?>
            </div>
        </div>
        <div id="message" class="alert alert-success" style="display: none;"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.clear-btn').click(function() {
                const orderId = $(this).data('id');
                if (confirm('Are you sure you want to clear this order?')) {
                    $.ajax({
                        url: '',
                        method: 'POST',
                        data: { clear_order: true, order_id: orderId },
                        success: function(response) {
                            const res = JSON.parse(response);
                            $('#message').text(res.message).show();
                            setTimeout(() => $('#message').fadeOut(), 3000);
                            setTimeout(() => window.location.reload(), 3000);
                        }
                    });
                }
            });

            $('.status-select').change(function() {
                const orderId = $(this).data('id');
                const newStatus = $(this).val();
                $.ajax({
                    url: '',
                    method: 'POST',
                    data: { update_status: true, order_id: orderId, status: newStatus },
                    success: function(response) {
                        const res = JSON.parse(response);
                        $('#message').text(res.message).show();
                        $('#order-' + orderId + ' .status').text(res.status);
                        setTimeout(() => $('#message').fadeOut(), 3000);
                    }
                });
            });
        });
    </script>
</body>
</html>
