<!-- delete_kaprodi.php -->
<?php
session_start();
require('../include/koneksi.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login_admin.html');
    exit();
}

// Handle deletion of Kaprodi based on ID from query string
if (!isset($_GET['nidn']) || !is_numeric($_GET['nidn'])) {
    header('Location: manage_kaprodi.php'); // Redirect if ID is not provided or invalid
    exit();
}

$id = $_GET['nidn'];

// Perform database deletion
$query = "DELETE FROM kaprodi WHERE nidn = $id";
$result = mysqli_query($koneksi, $query);

if ($result) {
    header('Location: manage_kaprodi.php'); // Redirect to manage Kaprodi page after successful deletion
    exit();
} else {
    echo "Failed to delete Kaprodi.";
}
?>
