<?php
session_start();
include '../include/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nidn = $_POST['nidn'];
    $password = $_POST['password'];

    // Query the database for the user
    $stmt = $koneksi->prepare("SELECT * FROM kaprodi WHERE nidn = ?");
    $stmt->bind_param("s", $nidn);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['nidn'] = $user['nidn'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];
        // Redirect to a dashboard or home page
        header("Location: index_kaprodi.php");
    } else {
        // Redirect back to login with error
        header("Location: index.php?error=Invalid NIDN or Password");
    }
} else {
    header("Location: index.php");
}
?>
