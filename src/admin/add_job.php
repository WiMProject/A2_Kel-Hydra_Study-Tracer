<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'Anda harus login untuk mengakses halaman ini';
    header('Location: login_admin.html');
    exit();
}

// Include database connection
include '../include/koneksi.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($koneksi, $_POST['title']);
    $company = mysqli_real_escape_string($koneksi, $_POST['company']);
    $location = mysqli_real_escape_string($koneksi, $_POST['location']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);

    $query = "INSERT INTO jobs (title, company, location, description) VALUES ('$title', '$company', '$location', '$description')";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['msg'] = 'Job listing added successfully!';
    } else {
        $_SESSION['msg'] = 'Failed to add job listing: ' . mysqli_error($koneksi);
    }

    header('Location: jobs.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Add Job Listing</title>
</head>
<body class="bg-gray-100 text-gray-900">

<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index_admin.php" class="text-white text-2xl font-bold">Manage Jobs Listing</a>
        <button class="text-white md:hidden" id="mobile-menu-button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div class="hidden md:flex space-x-4">
            <a href="logout.php" class="text-white hover:text-gray-400">Log Out</a>
        </div>
    </div>
    <div class="md:hidden" id="mobile-menu">
        <a href="logout.php" class="text-white hover:text-gray-400">Log Out</a>
    </div>
</nav>

<div class="container mx-auto my-8">
    <h1 class="text-5xl font-bold text-center mb-8">Tambah Lowongan Kerja</h1>
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
        <form method="POST" action="add_job.php">
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Judul Pekerjaan</label>
                <input type="text" name="title" id="title" class="w-full border border-gray-300 p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label for="company" class="block text-gray-700">Perusahaan</label>
                <input type="text" name="company" id="company" class="w-full border border-gray-300 p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label for="location" class="block text-gray-700">Lokasi</label>
                <input type="text" name="location" id="location" class="w-full border border-gray-300 p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" class="w-full border border-gray-300 p-2 rounded" required></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    // JavaScript to toggle mobile menu
    document.getElementById('mobile-menu-button').onclick = function() {
        var menu = document.getElementById('mobile-menu');
        if (menu.style.display === 'none' || menu.style.display === '') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    };
</script>

</body>
</html>
