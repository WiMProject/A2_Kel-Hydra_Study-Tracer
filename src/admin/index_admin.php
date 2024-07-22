<?php
session_start();
require('../include/koneksi.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    $_SESSION['msg'] = 'Anda harus login untuk mengakses halaman ini';
    header('Location: login_admin.html');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Admin Panel</title>
    <style>
        /* Custom styles for mobile menu */
        #mobile-menu {
            display: none;
        }
        /* Swiper custom styles */
        .swiper-container {
            width: 100%;
            height: 800px;
            margin: 200;
        }
        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }
        .swiper-pagination-bullet {
            background-color: #fff;
            opacity: 0.8;
        }
        .swiper-button-next, .swiper-button-prev {
            color: #fff;
        }
    </style>
</head>
<body class="bg-gray-100">

<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index_admin.php" class="text-white text-2xl font-bold">Admin Panel</a>
        <a href="logout.php" class="text-white hover:text-gray-400">Log Out</a>
    </div>
</nav>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Manage Job Listings</h2>
            <a href="add_job.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add New Job Listing</a>
            <a href="jobs.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View All Job</a>
            <a href="view_job_submit.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2">View All Job Listings</a>
        </div>

        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Lihat Kuisioner</h2>
            <a href="admin_dashboard.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lihat Hasil Kuisioner</a>
        </div>
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Manage Alumni</h2>
            <a href="manage_alumni.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Manage Alumni</a>
        </div>
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Manage Kaprodi</h2>
            <a href="manage_kaprodi.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Manage Kaprodi</a>
        </div>
    </div>
</div>
</body>
</html>
