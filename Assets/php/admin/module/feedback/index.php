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

// Menghapus data tertentu dari tabel feedback jika tombol Clear ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id_feedback = $_POST['delete_id'];
    $sql_delete = "DELETE FROM feedback WHERE id_feedback = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id_feedback);
    if ($stmt->execute()) {
        echo "<script>alert('Feedback record has been deleted.'); window.location.href = window.location.href;</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
}

// Mengambil data dari tabel feedback
$sql = "SELECT id_feedback, name, email, message, satisfaction, terms_accepted, tgl_input FROM feedback";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-wrapper {
            max-height: 400px;
            overflow-y: auto;
        }
        .sortable:hover {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Feedback List</h1>
        <form id="sort-form" class="form-inline mb-3">
            <div class="form-group mr-2">
                <label for="sort_order" class="mr-2">Sort by Satisfaction:</label>
                <select name="sort_order" id="sort_order" class="form-control">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
        </form>
        <div class="table-wrapper">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th class="sortable" data-sort="satisfaction">Satisfaction</th>
                        <th>Terms Accepted</th>
                        <th>Date Submitted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="feedback-table">
                    <?php
                    if ($result->num_rows > 0) {
                        // Menampilkan data per baris
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
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            function sortTable(order) {
                var rows = $('#feedback-table tr').get();
                rows.sort(function(a, b) {
                    var A = $(a).children('td').eq(4).text().toUpperCase();
                    var B = $(b).children('td').eq(4).text().toUpperCase();
                    if(order == 'asc') {
                        return (A < B) ? -1 : (A > B) ? 1 : 0;
                    } else {
                        return (A > B) ? -1 : (A < B) ? 1 : 0;
                    }
                });
                $.each(rows, function(index, row) {
                    $('#feedback-table').append(row);
                });
            }

            $('#sort_order').on('change', function() {
                var sortOrder = $(this).val();
                sortTable(sortOrder);
            });

            // Initial sort
            sortTable('asc');

            // Handle delete button click
            $(document).on('submit', '.delete-form', function(event) {
                event.preventDefault();
                const id_feedback = $(this).data('id');
                $.ajax({
                    url: '',
                    method: 'POST',
                    data: { delete_id: id_feedback },
                    success: function(response) {
                        alert('Feedback record has been deleted.');
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
