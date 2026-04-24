<?php
$conn = new mysqli("localhost", "root", "", "crud_app");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>