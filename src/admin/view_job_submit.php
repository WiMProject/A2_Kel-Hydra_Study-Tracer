<?php
session_start();

// Check if the user is logged in and is an admin (you need to implement admin authentication logic)
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['msg'] = 'Anda harus login sebagai admin untuk mengakses halaman ini';
    header('Location: login_admin.html');
    exit();
}

// Include database connection
include '../include/koneksi.php';

// Fetch all job submissions from database
$query = "SELECT * FROM apply_jobs";
$result = mysqli_query($koneksi, $query);

// Function to get the job title from jobs table based on job_id
function getJobTitle($koneksi, $job_id) {
    $query = "SELECT title FROM jobs WHERE id = $job_id";
    $result = mysqli_query($koneksi, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $job = mysqli_fetch_assoc($result);
        return $job['title'];
    } else {
        return 'Unknown Job';
    }
}

// Handle delete job listing request
if (isset($_POST['delete'])) {
    $job_id = $_POST['jobs_id'];
    $delete_query = "DELETE FROM apply_jobs WHERE jobs_id = $job_id";
    if (mysqli_query($koneksi, $delete_query)) {
        $_SESSION['msg'] = 'Job listing deleted successfully!';
    } else {
        $_SESSION['msg'] = 'Failed to delete job listing: ' . mysqli_error($koneksi);
    }
    header('Location: view_job_submit.php');
    exit();
}

// Handle edit job listing request
if (isset($_POST['apply'])) {
    $job_id = $_POST['jobs_id'];
    $sql = "UPDATE apply_jobs SET isApply='1' WHERE jobs_id=$job_id";
    if (mysqli_query($koneksi, $sql)) {
        header('Refresh:0');
        exit();
    } 
    
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
    <title>View Job Submissions</title>
</head>
<body class="bg-gray-100 text-gray-900">

<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index_admin.php" class="text-white text-2xl font-bold">DATA SUBMIT LOWONGAN KERJA</a>
        <button class="text-white md:hidden" id="mobile-menu-button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div class="hidden md:flex space-x-4">
            <a href="index_admin.php" class="text-white hover:text-gray-400">Home</a>
            <a href="add_job.php" class="text-white hover:text-gray-400">Tambah Lowongan</a>
            <a href="logout.php" class="text-white hover:text-gray-400">Log Out</a>
        </div>
    </div>
    <div class="md:hidden" id="mobile-menu">
        <a href="index_admin.php" class="text-white hover:text-gray-400">Home</a>
        <a href="add_job.php" class="text-white hover:text-gray-400">Tambah Lowongan</a>
        <a href="logout.php" class="text-white hover:text-gray-400">Log Out</a>
    </div>
</nav>

<div class="container mx-auto my-8">
    <h1 class="text-5xl font-bold text-center mb-8">Lihat Submisi Lowongan Kerja</h1>
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="bg-green-200 p-4 mb-4 text-green-800"><?php echo $_SESSION['msg']; ?></div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars(getJobTitle($koneksi, $row['jobs_id'])); ?></h2>
                    <p class="text-gray-700"><strong>NIM:</strong> <?php echo htmlspecialchars($row['nim']); ?></p>
                    <p class="text-gray-700"><strong>Nama:</strong> <?php echo htmlspecialchars($row['nama']); ?></p>
                    <p class="text-gray-700"><strong>Tahun:</strong> <?php echo htmlspecialchars($row['tahun']); ?></p>
                    <p class="text-gray-700"><strong>Jurusan:</strong> <?php echo htmlspecialchars($row['jurusan']); ?></p>
                    <div class="mt-4 flex justify-between">
                        <form method="POST" action="view_job_submit.php">
                            <input type="hidden" name="jobs_id" value="<?php echo $row['jobs_id']; ?>">
                            <button type="submit" name="apply" class="bg-blue-500 text-white px-4 py-2 rounded"><?= $row['isApply'] ? "Applied" : "Apply" ?></button>
                        </form>
                        <form method="POST" action="view_job_submit.php" onsubmit="return confirm('Are you sure you want to delete this job listing?');">
                            <input type="hidden" name="jobs_id" value="<?php echo $row['jobs_id']; ?>">
                            <button type="submit" name="delete" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
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
