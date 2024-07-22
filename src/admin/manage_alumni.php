<?php
session_start();
require('../include/koneksi.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login_admin.html');
    exit();
}

// Handle search query
$search_query = "";
if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
}

// Handle delete request
if (isset($_GET['nim'])) {
    $delete_id = $_GET['nim'];
    $delete_query = "DELETE FROM alumni WHERE nim = ?";
    $stmt = $koneksi->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        header('Location: manage_alumni.php');
        exit();
    } else {
        echo "Error deleting record: " . $koneksi->error;
    }
}

// Fetch alumni data
if ($search_query) {
    $query = "SELECT * FROM alumni WHERE nim LIKE ?";
    $stmt = $koneksi->prepare($query);
    $search_param = "%".$search_query."%";
    $stmt->bind_param("s", $search_param);
} else {
    $query = "SELECT * FROM alumni";
    $stmt = $koneksi->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Manage Alumni</title>
</head>
<body class="bg-gray-100">

<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index_admin.php" class="text-white text-2xl font-bold">Admin Panel</a>
        <a href="logout.php" class="text-white hover:text-gray-400">Log Out</a>
    </div>
</nav>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Manage Alumni</h1>

    <!-- Search Form -->
    <form method="POST" action="manage_alumni.php" class="mb-6">
        <input type="text" name="search_query" placeholder="Search by NIM" class="px-4 py-2 border rounded w-full" value="<?= htmlspecialchars($search_query) ?>">
        <button type="submit" name="search" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Search</button>
    </form>

    <!-- Alumni Table -->
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Alumni List</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">NIM</th>
                        <th class="border border-gray-300 px-4 py-2">Nama</th>
                        <th class="border border-gray-300 px-4 py-2">Jurusan</th>
                        <th class="border border-gray-300 px-4 py-2">Tahun Lulus</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class='border border-gray-300 px-4 py-2'><?= $row['nim'] ?></td>
                            <td class='border border-gray-300 px-4 py-2'><?= $row['nama'] ?></td>
                            <td class='border border-gray-300 px-4 py-2'><?= $row['jurusan'] ?></td>
                            <td class='border border-gray-300 px-4 py-2'><?= $row['tahun_lulus'] ?></td>
                            <td class='border border-gray-300 px-4 py-2'>
                                <a href="edit_alumni.php?nim=<?= $row['nim'] ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                <a href="manage_alumni.php?nim=<?= $row['nim'] ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if ($result->num_rows == 0) : ?>
                        <tr>
                            <td colspan='6' class='border border-gray-300 px-4 py-2 text-center'>No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
