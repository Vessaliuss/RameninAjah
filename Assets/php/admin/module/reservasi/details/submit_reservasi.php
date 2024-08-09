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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $how_many_people = $_POST['how_many_people'];
  $email = $_POST['email'];
  $number = $_POST['number'];

  $sql = "INSERT INTO reservasi (nama, jumlah_orang, email, nomor_telepon)
  VALUES ('$name', '$how_many_people', '$email', '$number')";

  if ($conn->query($sql) === TRUE) {
    echo "New reservation created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>
