<?php
// Inisialisasi session
session_start();
include '../include/koneksi.php';

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
        header('Location: login_admin.html');
        exit();
    }
}

if (isset($_POST['delete'])) {
    $job_id = $_POST['id'];
    $delete_query = "DELETE FROM jobs WHERE id = $job_id";
    if (mysqli_query($koneksi, $delete_query)) {
        $_SESSION['msg'] = 'Job deleted successfully!';
    } else {
        $_SESSION['msg'] = 'Failed to delete job : ' . mysqli_error($koneksi);
    }
    header('Refresh:0');
    exit();
}

// Update the last activity time
$_SESSION['last_activity'] = time();

// Mengecek username pada session
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'Anda harus login untuk mengakses halaman ini';
    header('Location: login_admin.php');
    exit();
}

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
    <title>Job Listings</title>
</head>
<body class="bg-gray-100 text-gray-900">

<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index_admin.php" class="text-white text-2xl font-bold">JOBS LISTING</a>
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
    <h1 class="text-5xl font-bold text-center mb-8">Daftar Lowongan Kerja</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($jobs as $job): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($job['title']); ?></h2>
                    <p class="text-gray-700"><strong>Perusahaan:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
                    <p class="text-gray-700"><strong>Lokasi:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                    <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($job['description']); ?></p>
                    <form method="POST" action="jobs.php" onsubmit="return confirm('Are you sure you want to delete this job?');">
                            <input type="hidden" name="id" value="<?php echo $job['id']; ?>">
                            <button type="submit" name="delete" class="mt-4 inline-block bg-red-800 text-white px-4 py-2 rounded">Delete</button>
                    </form>
                    <!-- <button onclick="openApplyModal(<?php echo $job['id']; ?>)" class="mt-4 inline-block bg-gray-800 text-white px-4 py-2 rounded">Submit</button> -->
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
                <input type="hidden" name="job_id" id="job_id">
                <div class="mb-4">
                    <label for="nim" class="block text-gray-700">NIM</label>
                    <input type="text" name="nim" id="nim" class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama" class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="tahun" class="block text-gray-700">Tahun</label>
                    <input type="text" name="tahun" id="tahun" class="w-full border border-gray-300 p-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="jurusan" class="block text-gray-700">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" class="w-full border border-gray-300 p-2 rounded">
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
                <a href="../src/admin/index.php" class="text-2xl font-bold text-white">TRACER STUDY</a>
                <p class="mt-4 text-gray-400">Connecting Alumni with Their Alma Mater</p>
            </div>
            <div class="mt-6 md:mt-0">
                <h3 class="text-lg font-semibold mb-2">Navigation</h3>
                <div class="flex space-x-4">
                    <ul>
                        <li><a href="../src/admin/index.php" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="add_job.php" class="text-gray-400 hover:text-white">Add Jobs?</a></li>
                        <li><a href="view_job_submit.php" class="text-gray-400 hover:text-white">View Submit Jobs?</a></li>
                        <li><a href="../src/admin/admin_dashboard.php" class="text-gray-400 hover:text-white">View Result Kuesioner?</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-6 text-center">
            <p class="text-gray-400">&copy; 2024 TRACER STUDY. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    function openApplyModal(jobId) {
        document.getElementById('job_id').value = jobId;
        document.getElementById('apply-modal').style.display = 'flex';
    }

    function closeApplyModal() {
        document.getElementById('apply-modal').style.display = 'none';
    }

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
