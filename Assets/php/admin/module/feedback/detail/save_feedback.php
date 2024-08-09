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

// Mendapatkan data dari form
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$satisfaction = $_POST['satisfaction'];
$terms_accepted = isset($_POST['terms']) ? 1 : 0;

// Melakukan sanitasi input
$name = $conn->real_escape_string($name);
$email = $conn->real_escape_string($email);
$message = $conn->real_escape_string($message);
$satisfaction = $conn->real_escape_string($satisfaction);

// Menyimpan data ke dalam tabel feedback
$sql = "INSERT INTO feedback (name, email, message, satisfaction, terms_accepted)
VALUES ('$name', '$email', '$message', '$satisfaction', '$terms_accepted')";

if ($conn->query($sql) === TRUE) {
    echo "Feedback berhasil disimpan!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi
$conn->close();
?>
