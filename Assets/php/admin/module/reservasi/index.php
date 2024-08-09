<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_toko";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle deletion
if (isset($_POST['delete_id'])) {
  $id = $_POST['delete_id'];
  $sql = "DELETE FROM reservasi WHERE id_reservasi='$id'";
  $conn->query($sql);
}

// Retrieve data
$sql = "SELECT * FROM reservasi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Data Reservasi</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    table {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-center">Data Reservasi</h1>
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Jumlah Orang</th>
          <th>Email</th>
          <th>Nomor Telepon</th>
          <th>Tanggal Reservasi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id_reservasi"]. "</td>
                    <td>" . $row["nama"]. "</td>
                    <td>" . $row["jumlah_orang"]. "</td>
                    <td>" . $row["email"]. "</td>
                    <td>" . $row["nomor_telepon"]. "</td>
                    <td>" . $row["tanggal_reservasi"]. "</td>
                    <td>
                      <form method='POST' action='' style='display:inline-block;'>
                        <input type='hidden' name='delete_id' value='" . $row["id_reservasi"]. "'>
                        <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
                      </form>
                      <a href='https://wa.me/" . $row["nomor_telepon"]. "' target='_blank' class='btn btn-success btn-sm' style='margin-left: 5px;'>Hubungi</a>
                    </td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='7' class='text-center'>Tidak ada data reservasi</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>

<?php
$conn->close();
?>
