<?php
$host = 'localhost';
$user = 'root';
$password = '545832';
$database = 'db_uas_tracer';

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>