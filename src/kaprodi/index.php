<?php
require('koneksi.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <title>Blog</title>
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
<body class="bg-gray-100 text-gray-900">

<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index.php" class="text-white text-2xl font-bold">TRACER STUDY</a>
        <button class="text-white md:hidden" id="mobile-menu-button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div class="hidden md:flex space-x-4">
            <a href="index.php" class="text-white hover:text-gray-400">Home</a>
            <a href="../src/kaprodi/feedback.php" class="text-white hover:text-gray-400">Feedback</a>
            <a href="logout.php" class="text-white hover:text-gray-400">Logout</a>
        </div>
    </div>
    <div class="md:hidden" id="mobile-menu">
            <a href="index.php" class="text-white hover:text-gray-400">Home</a>
            <a href="../src/kaprodi/feedback.php" class="text-white hover:text-gray-400">Feedback</a>
            <a href="logout.php" class="text-white hover:text-gray-400">Logout</a>

    </div>
</nav>

<div class="container mx-auto my-8">
    <div class="text-center mb-8">
        <h1 class="text-5xl font-bold">Welcome to Study Tracer</h1>
        <p class="text-lg text-gray-700">Anda Login Sebagai Kaprodi</p>
    </div>
    
    <!-- Slider Container -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide flex items-center justify-center">
                <img src="https://kuliahonline.usbypkp.ac.id/pluginfile.php?file=%2F1%2Ftheme_moove%2Fsliderimage1%2F1715936971%2FIMG_3941-e1580188722870.jpg" alt="Slide 1">
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide flex items-center justify-center">
                <img src="https://lh3.googleusercontent.com/p/AF1QipN1_BwCb2qG5JrIkUQ4FKIY1sssd_OXCKxUxup7=s1360-w1360-h1020" alt="Slide 2">
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide flex items-center justify-center">
                <img src="https://lh3.googleusercontent.com/p/AF1QipP64c28nwUsoI80aYDxl03ERpEBCCV5QCyEKozz=s1360-w1360-h1020" alt="Slide 3">
            </div>
            <!-- Slide 4 -->
            <div class="swiper-slide flex items-center justify-center">
                <img src="https://lh3.googleusercontent.com/p/AF1QipPH-kBcrDt7iQqBuywpwTLN8kag7RHOnU4oocfN=s1360-w1360-h1020" alt="Slide 3">
            </div>
            <!-- Add more slides as needed -->
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="images/s1-akuntansi-prodi" alt="Image 1" class="w-full h-48 object-cover">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-2">Sejarah Universitas</h2>
                <p class="text-gray-700">This is a short description of the blog post. It provides a brief summary of the content.</p>
                <a href="article.php?id=1" class="mt-4 inline-block bg-gray-800 text-white px-4 py-2 rounded">Read More</a>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="https://usbypkp.ac.id/wp-content/uploads/2020/12/s1-akuntansi-prodi.jpg" alt="Image 2" class="w-full h-48 object-cover">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-2">Visi Misi Universitas</h2>
                <p class="text-gray-700">This is another description of a blog post. Learn more about the content inside.</p>
                <a href="article.php?id=2" class="mt-4 inline-block bg-gray-800 text-white px-4 py-2 rounded">Read More</a>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="https://via.placeholder.com/400" alt="Image 3" class="w-full h-48 object-cover">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-2">Fasilitas Universitas</h2>
                <p class="text-gray-700">This is a brief summary of another interesting blog post.</p>
                <a href="article.php?id=3" class="mt-4 inline-block bg-gray-800 text-white px-4 py-2 rounded">Read More</a>
            </div>
        </div>
</div>
</div>
<!-- Footer -->
<footer class="bg-gray-700 text-white py-8">
    <div class="container mx-auto text-center md:text-left">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-start">
            <!-- Logo and Description -->
            <div class="mb-6 md:mb-0">
                <a href="index.php" class="text-2xl font-bold text-white">TRACER STUDY</a>
                <p class="mt-4 text-gray-400">Connecting Alumni with Their Alma Mater</p>
            </div>
            <!-- Social Media Links -->
            <div class="mt-6 md:mt-0">
                <h3 class="text-lg font-semibold mb-2">Navigation</h3>
                <div class="flex space-x-4">
                    <ul>
                        <li><a href="../alumni/index.php" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="../src/kaprodi/feedback.php" class="text-gray-400 hover:text-white">Feedback</a></li>
                        <li><a href="logout.php" class="text-gray-400 hover:text-white">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-6 text-center">
            <p class="text-gray-400">&copy; 2024 Hydra.corp. All rights reserved.</p>
        </div>
    </div>
</footer>


<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
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

    // Initialize Swiper
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>

</body>
</html>
