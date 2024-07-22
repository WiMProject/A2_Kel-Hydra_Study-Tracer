<?php
session_start();
require('../include/koneksi.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login_kaprodi.html');
    exit();
}

// Fetch kaprodi data
$sql = "SELECT * FROM kaprodi";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Manage Kaprodi</title>
</head>
<body class="bg-gray-100">
<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index_admin.php" class="text-white text-2xl font-bold">Admin Panel</a>
        <a href="logout.php" class="text-white hover:text-gray-400">Log Out</a>
    </div>
</nav>
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Manage Kaprodi</h1>
    <a href="add_kaprodi.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Add New Kaprodi</a>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">NIDN</th>
                <th class="py-2 px-4 border-b">Nama Kaprodi</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td class="py-2 px-4 border-b"><?php echo $row['nidn']; ?></td>
                <td class="py-2 px-4 border-b"><?php echo $row['nama']; ?></td>
                <td class="py-2 px-4 border-b"><?php echo $row['email']; ?></td>
                <td class="py-2 px-4 border-b">
                    <a href="edit_kaprodi.php?nidn=<?php echo $row['nidn']; ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
                    <a href="delete_kaprodi.php?nidn=<?php echo $row['nidn']; ?>" class="text-red-500 hover:text-red-700 ml-4">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
