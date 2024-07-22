<?php
// Inisialisasi session
session_start();

// Set the session timeout duration (in seconds)
$session_timeout = 1400;

// Check if the session variable for last activity is set
if (isset($_SESSION['last_activity'])) {
    // Calculate the session lifetime
    $session_lifetime = time() - $_SESSION['last_activity'];

    // Check if the session has expired
    if ($session_lifetime > $session_timeout) {
        // Destroy the session and redirect to login page
        session_unset();
        session_destroy();
        $_SESSION['msg'] = 'Session telah berakhir. Silakan login kembali.';
        header('Location: login_alumni.html');
        exit();
    }
}

// Update the last activity time
$_SESSION['last_activity'] = time();

// Mengecek username pada session
if (!isset($_SESSION['nim'])) {
    $_SESSION['msg'] = 'Anda harus login untuk mengakses halaman ini';
    header('Location: login_alumni.html');
    exit();
}

// Include database connection
include '../../src/include/koneksi.php';

// Fetch job listings from database
$jobs = [];
$query = "SELECT * FROM jobs";
$result = mysqli_query($koneksi, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $jobs[] = $row;
    }
} else {
    die("Could not fetch job listings: " . mysqli_error($koneksi));
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
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <title>Alumni Dashboard</title>
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
        <a href="index_alumni.php" class="text-white text-2xl font-bold">TRACER STUDY</a>
        <button class="text-white md:hidden" id="mobile-menu-button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div class="hidden md:flex space-x-4">
            <a href="kuesioner.php" class="text-white hover:text-gray-400">Quisioner</a>
            <a href="logout.php" class="text-white hover:text-gray-400">Logout</a>
        </div>
    </div>
    <div class="md:hidden" id="mobile-menu">
            <a href="kuesioner.php" class="text-white hover:text-gray-400">Quisioner</a>
            <a href="logout.php" class="text-white hover:text-gray-400">Logout</a>
    </div>
</nav>

<div class="container mx-auto my-8">
    <div class="text-center mb-8">
        <h1 class="text-5xl font-bold">Welcome to Study Tracer</h1>
        <p class="text-lg text-gray-700">Web ini bertujuan untuk mengisi kuesioner dari alumni dan mengisi penilaian kepada alumni oleh kaprodi </p>
        <p class="text-lg text-gray-700">Login Berhasil </p>
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
                <p class="text-gray-700">Pengalaman Yayasan Pendidikan Keuangan dan Perbankan (YPKP) mengelola pendidikan lebih dari 44 tahun, semenjak 1968 mengelola Akademik Bank Nasional (ABN) Cabang Bandung , kemudian ABN berubah menjadi AKUBANK YPKP, dan berubah lagi menjadi STIE YPKP, serta mendirikan STT YPKP. Selanjutnya STIE YPKP dan STT YPKP bergabung ditambah Fakultas Ilmu Komunikasi dan Administrasi sehingga menjadi Universitas Sangga Buana YPKP.</p>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="https://usbypkp.ac.id/wp-content/uploads/2020/12/s1-akuntansi-prodi.jpg" alt="Image 2" class="w-full h-48 object-cover">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-2">Visi Misi Universitas</h2>
                <p class="text-gray-700">1. Menyelenggarakan pendidikan bermutu berbasis kewirausahaan dan berwawasan global.</p>
                <p class="text-gray-700">2. Menyelenggarakan penelitian bermutu untuk menunjang penyelenggaraan pendidikan berbasis kewirausahaan dan berwawasan global.</p>
                <p class="text-gray-700">3. Menyelenggarakan pengabdian kepada masyarakat dalam rangka mengaplikasikan hasil pendidikan dan penelitian.</p>
                <p class="text-gray-700">4. Menjalin kerjasama dalam dan luar negeri secara berkelanjutan dengan institusi pendidikan, lembaga penelitian, pemerintah, lembaga profesi dan pelaku usaha.</p>
                <p class="text-gray-700">5. Mengembangkan universitas dengan tata kelola bermutu yang dapat menunjang penyelenggaraan tridharma perguruan tinggi berbasis kewirausahaan.</p>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="https://via.placeholder.com/400" alt="Image 3" class="w-full h-48 object-cover">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-2">Fasilitas Universitas</h2>
                <p class="text-gray-700">1. Kampus USB YPKP.</p>
                <p class="text-gray-700">2. Ruang Kuliah.</p>
                <p class="text-gray-700">3. Perpustakaan.</p>
                <p class="text-gray-700">4. Laboratorium.</p>
                <p class="text-gray-700">5. Galery Investasi Pasar Modal.</p>
                <p class="text-gray-700">6. Sarana Peribadatan (Masjid).</p>
                <p class="text-gray-700">7. Koperasi Mahasiswa.</p>
                <p class="text-gray-700">8. Koperasi Dosen dan Karyawan.</p>
                <p class="text-gray-700">9. Gedung Serba Guna (GSG).</p>
                <p class="text-gray-700">10. Gedung Olah Raga (Lapangan Futsal).</p>
                <p class="text-gray-700">11. Student Center.</p>
                <p class="text-gray-700">12. Balai Pengobatan.</p>
                <p class="text-gray-700">13. Sarana Parkir.</p>
            </div>
        </div>
</div>
</div>
<div class="container mx-auto my-8">
    <h1 class="text-5xl font-bold text-center mb-8">Daftar Lowongan Kerja</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($jobs as $job): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($job['title']); ?></h2>
                    <p class="text-gray-700"><strong>Perusahaan:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
                    <p class="text-gray-700"><strong>Lokasi:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                    <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($job['description']); ?></p>
                    <button onclick="openApplyModal(<?php echo $job['id']; ?>)" class="mt-4 inline-block bg-gray-800 text-white px-4 py-2 rounded">Submit</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Apply Modal -->
<div id="apply-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg overflow-hidden w-full max-w-md">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Apply for Job</h2>
            <form id="apply-form" method="POST" enctype="multipart/form-data" action="apply_job.php">
                <input type="hidden" name="jobs_id" id="job_id">
                <div class="mb-4">
                    <label for="nim" class="block text-gray-700">NIM</label>
                    <input type="text" name="nim" id="nim" class="w-full border border-gray-300 p-2 rounded" value="<?= $_SESSION['nim'] ?>">
                </div>
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama" class="w-full border border-gray-300 p-2 rounded" value="<?= $_SESSION['nama'] ?>">
                </div>
                <div class="mb-4">
                    <label for="tahun" class="block text-gray-700">Tahun</label>
                    <input type="text" name="tahun" id="tahun" class="w-full border border-gray-300 p-2 rounded" value="<?= $_SESSION['tahun_lulus'] ?>">
                </div>
                <div class="mb-4">
                    <label for="jurusan" class="block text-gray-700">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" class="w-full border border-gray-300 p-2 rounded" value="<?= $_SESSION['jurusan'] ?>">
                </div>
                <div class="mb-4">
                    <label for="file" class="block text-gray-700">Upload File</label>
                    <input type="file" name="file" id="file" class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeApplyModal()" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Footer -->
<footer class="bg-gray-700 text-white py-8">
    <div class="container mx-auto text-center md:text-left">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-start">
            <!-- Logo and Description -->
            <div class="mb-6 md:mb-0">
                <a href="index_alumni.php" class="text-2xl font-bold text-white">TRACER STUDY</a>
                <p class="mt-4 text-gray-400">Connecting Alumni with Their Alma Mater</p>
            </div>
            <!-- Social Media Links -->
            <div class="mt-6 md:mt-0">
                <h3 class="text-lg font-semibold mb-2">Navigation</h3>
                <div class="flex space-x-4">
                    <ul>
                        <li><a href="kuesioner.php" class="text-gray-400 hover:text-white">Quisioner</a></li>
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
    document.getElementById('mobile-menu-button').onclick = function() {
        var menu = document.getElementById('mobile-menu');
        if (menu.style.display === 'none' || menu.style.display === '') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    };
    function openApplyModal(jobId) {
        document.getElementById('job_id').value = jobId;
        document.getElementById('apply-modal').style.display = 'flex';
    }

    function closeApplyModal() {
        document.getElementById('apply-modal').style.display = 'none';
    }
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
