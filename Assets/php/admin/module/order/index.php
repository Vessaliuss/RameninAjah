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

// Handle the POST request for processing the order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = $_POST['customerName'];
    $tableNumber = $_POST['tableNumber'];
    $orderDate = $_POST['orderDate'];
    $orderItems = json_decode($_POST['orderItems'], true);

    // Collect items' names and quantities
    $itemsDetails = [];
    foreach ($orderItems as $item) {
        $itemsDetails[] = $item['name'] . " (" . $item['qty'] . ")";
    }
    $itemsDetailsStr = implode(", ", $itemsDetails);

    // Insert order data into `orders` table
    $sql = "INSERT INTO orders (table_number, customer_name, order_date, total_order, status, items_details)
            VALUES ('$tableNumber', '$customerName', '$orderDate', 0, 'Pending', '$itemsDetailsStr')";

    if ($conn->query($sql) === TRUE) {
        $orderId = $conn->insert_id;

        $totalOrder = 0;
        foreach ($orderItems as $item) {
            $itemId = $item['id'];
            $qty = $item['qty'];
            $subtotal = $item['subtotal'];

            // Insert each item into `order_items` table
            $sql = "INSERT INTO order_items (order_id, item_id, quantity, subtotal)
                    VALUES ('$orderId', '$itemId', '$qty', '$subtotal')";
            $conn->query($sql);

            $totalOrder += $subtotal;
        }

        // Update total order amount in the `orders` table
        $sql = "UPDATE orders SET total_order = '$totalOrder' WHERE id = '$orderId'";
        $conn->query($sql);

        // Insert table number and status into `meja` table with status 'Diisi'
        $sql = "INSERT INTO meja (table_number, costumer_name, order_date, total_order, status)
                VALUES ('$tableNumber', '$customerName', '$orderDate', '$totalOrder', 'Diisi')";
        $conn->query($sql);

        echo "Sukses";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    exit;
}

// Fetch data
$sql = "SELECT id, id_barang, id_kategori, nama_barang, harga_jual, stok FROM barang";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }
        .badge-counter {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 25px;
            height: 25px;
            background: green;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .btn-with-counter {
            position: relative;
        }
    </style>
</head>
<body>
    <h1>Order Menu</h1>
    <input type="text" id="searchInput" class="form-control" placeholder="Cari item..." onkeyup="searchItem()"><br>
    <form id="orderForm">
        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Id Barang</th>
                        <th>Id Kategori</th>
                        <th>Nama Barang</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="itemTable">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["id_barang"] . "</td>";
                            echo "<td>" . $row["id_kategori"] . "</td>";
                            echo "<td>" . $row["nama_barang"] . "</td>";
                            echo "<td>Rp. " . number_format($row["harga_jual"], 0, ',', '.') . "</td>";
                            echo "<td>" . $row["stok"] . "</td>";
                            echo "<td>
                                    <button type='button' data-id='" . $row["id"] . "' data-nama='" . $row["nama_barang"] . "' data-harga='" . $row["harga_jual"] . "' data-stok='" . $row["stok"] . "' class='add-btn btn btn-primary btn-with-counter'>Tambahkan <span class='badge-counter' style='display:none'>0</span></button>
                                    <button type='button' data-id='" . $row["id"] . "' class='remove-btn btn btn-danger'>Kurangi</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No items available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div>
            <span>Total Item: <span id="totalItem">0</span></span>
            <button type="button" class="order-btn btn btn-success" id="orderButton">Order</button>
        </div>
    </form>

    <div id="orderModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:#285c64;color:#fff;">
                    <h5 class="modal-title">Order Detail</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;"></button>
                </div>
                <div class="modal-body">
                    <label for="customerNameInput">Nama Costumer:</label>
                    <input type="text" id="customerNameInput" class="form-control"><br>
                    <label for="tableNumberInput">No Meja:</label>
                    <input type="text" id="tableNumberInput" class="form-control"><br>
                    <label for="orderDateInput">Date:</label>
                    <input type="date" id="orderDateInput" class="form-control"><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order Name</th>
                                <th>Price</th>
                                <th>Stok</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="orderDetails">
                            <!-- Order details will be inserted here -->
                        </tbody>
                    </table>
                    <p>Total: <span id="totalPrice">Rp. 0</span></p>
                </div>
                <div class="modal-footer">
                    <button id="confirmOrder" class="btn btn-primary">Process</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
    <script>
        let totalItem = 0;
        let orderItems = [];

        $(document).ready(function() {
            $('.add-btn').click(function(e) {
                e.preventDefault();
                const itemId = $(this).data('id');
                const itemName = $(this).data('nama');
                const itemPrice = parseInt($(this).data('harga'));
                const itemStok = parseInt($(this).data('stok'));

                let itemExists = false;
                for (let i = 0; i < orderItems.length; i++) {
                    if (orderItems[i].id === itemId) {
                        orderItems[i].qty++;
                        orderItems[i].subtotal += itemPrice;
                        itemExists = true;
                        break;
                    }
                }

                if (!itemExists) {
                    orderItems.push({
                        id: itemId,
                        name: itemName,
                        price: itemPrice,
                        stok: itemStok,
                        qty: 1,
                        subtotal: itemPrice
                    });
                }

                totalItem++;
                $('#totalItem').text(totalItem);

                // Update badge counter on the button
                const badgeCounter = $(this).find('.badge-counter');
                badgeCounter.text(parseInt(badgeCounter.text()) + 1);
                badgeCounter.show();
            });

            $('.remove-btn').click(function(e) {
                e.preventDefault();
                const itemId = $(this).data('id');
                for (let i = 0; i < orderItems.length; i++) {
                    if (orderItems[i].id === itemId) {
                        orderItems[i].qty--;
                        orderItems[i].subtotal -= orderItems[i].price;
                        if (orderItems[i].qty <= 0) {
                            orderItems.splice(i, 1);
                        }
                        break;
                    }
                }

                totalItem--;
                if (totalItem < 0) totalItem = 0;
                $('#totalItem').text(totalItem);

                // Update badge counter on the button
                const badgeCounter = $(this).siblings('.add-btn').find('.badge-counter');
                const newCount = parseInt(badgeCounter.text()) - 1;
                badgeCounter.text(newCount);
                if (newCount <= 0) {
                    badgeCounter.hide();
                }
            });

            $('#orderButton').click(function() {
                $('#orderDateInput').val(new Date().toISOString().slice(0, 10));

                let orderDetailsHTML = '';
                let totalPrice = 0;
                for (let i = 0; i < orderItems.length; i++) {
                    orderDetailsHTML += `
                        <tr>
                            <td>${orderItems[i].name}</td>
                            <td>Rp. ${orderItems[i].price.toLocaleString()}</td>
                            <td>${orderItems[i].stok}</td>
                            <td>${orderItems[i].qty}</td>
                            <td>Rp. ${orderItems[i].subtotal.toLocaleString()}</td>
                            <td>
                                <button type="button" class="increase-btn btn btn-primary" data-id="${orderItems[i].id}">+</button>
                                <button type="button" class="decrease-btn btn btn-danger" data-id="${orderItems[i].id}">-</button>
                            </td>
                        </tr>
                    `;
                    totalPrice += orderItems[i].subtotal;
                }
                $('#orderDetails').html(orderDetailsHTML);
                $('#totalPrice').text('Rp. ' + totalPrice.toLocaleString());
                $('#orderModal').modal('show');
            });

            $('#orderModal').on('click', '.increase-btn', function() {
                const itemId = $(this).data('id');
                for (let i = 0; i < orderItems.length; i++) {
                    if (orderItems[i].id === itemId) {
                        orderItems[i].qty++;
                        orderItems[i].subtotal += orderItems[i].price;
                        break;
                    }
                }

                updateOrderDetails();
            });

            $('#orderModal').on('click', '.decrease-btn', function() {
                const itemId = $(this).data('id');
                for (let i = 0; i < orderItems.length; i++) {
                    if (orderItems[i].id === itemId) {
                        if (orderItems[i].qty > 1) {
                            orderItems[i].qty--;
                            orderItems[i].subtotal -= orderItems[i].price;
                        } else {
                            orderItems.splice(i, 1);
                        }
                        break;
                    }
                }

                updateOrderDetails();
            });

            $('#confirmOrder').click(function() {
                const customerName = $('#customerNameInput').val();
                const tableNumber = $('#tableNumberInput').val();
                const orderDate = $('#orderDateInput').val();

                if (customerName === '' || tableNumber === '' || orderItems.length === 0) {
                    alert('Please complete the order form and add items.');
                    return;
                }

                $.ajax({
                    url: '', // Corrected URL for processing the order
                    type: 'POST',
                    data: {
                        customerName: customerName,
                        tableNumber: tableNumber,
                        orderDate: orderDate,
                        orderItems: JSON.stringify(orderItems)
                    },
                    success: function(response) {
                        alert('Order placed successfully.');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Failed to place order.');
                    }
                });
            });

            function updateOrderDetails() {
                let orderDetailsHTML = '';
                let totalPrice = 0;
                for (let i = 0; i < orderItems.length; i++) {
                    orderDetailsHTML += `
                        <tr>
                            <td>${orderItems[i].name}</td>
                            <td>Rp. ${orderItems[i].price.toLocaleString()}</td>
                            <td>${orderItems[i].stok}</td>
                            <td>${orderItems[i].qty}</td>
                            <td>Rp. ${orderItems[i].subtotal.toLocaleString()}</td>
                            <td>
                                <button type="button" class="increase-btn btn btn-primary" data-id="${orderItems[i].id}">+</button>
                                <button type="button" class="decrease-btn btn btn-danger" data-id="${orderItems[i].id}">-</button>
                            </td>
                        </tr>
                    `;
                    totalPrice += orderItems[i].subtotal;
                }
                $('#orderDetails').html(orderDetailsHTML);
                $('#totalPrice').text('Rp. ' + totalPrice.toLocaleString());
            }

            function searchItem() {
                const input = document.getElementById("searchInput").value.toLowerCase();
                const items = document.getElementById("itemTable").getElementsByTagName("tr");

                for (let i = 0; i < items.length; i++) {
                    const item = items[i].getElementsByTagName("td")[3];
                    if (item) {
                        const txtValue = item.textContent || item.innerText;
                        items[i].style.display = txtValue.toLowerCase().indexOf(input) > -1 ? "" : "none";
                    }
                }
            }
        });
    </script>
</body>
</html>
