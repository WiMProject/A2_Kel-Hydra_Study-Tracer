<?php
include '../../koneksi.php';

session_start();
// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    $_SESSION['msg'] = 'Anda harus login untuk mengakses halaman ini';
    header('Location: login_admin.html');
    exit();
}

// Query to fetch status pekerjaan distribution
$query_status_pekerjaan = "SELECT pekerjaan, COUNT(*) as count FROM kuisioner GROUP BY pekerjaan";
$status_result = $koneksi->query($query_status_pekerjaan);

$status_counts = [];
while ($row = $status_result->fetch_assoc()) {
    $status_counts[$row['pekerjaan']] = $row['count'];
}



// Define all jurusan
$all_jurusan = ["d3_teknik_informatika", "s1_teknik_informatika", "s2_teknik_informatika"];

// Initialize $per_jurusan_counts with all jurusan and possible statuses
$per_jurusan_counts = [];
foreach ($all_jurusan as $jurusan) {
    $per_jurusan_counts[$jurusan] = [
        'bekerja' => 0,
        'tidak_bekerja' => 0,
        'melanjutkan_studi' => 0,
        'wirausaha' => 0,
        'lainnya' => 0
    ];
}

// Query to fetch employment status per degree program
$query_per_jurusan = "
    SELECT 
        jurusan, 
        pekerjaan, 
        COUNT(*) as count 
    FROM 
        kuisioner 
    GROUP BY 
        jurusan, pekerjaan";
$per_jurusan_result = $koneksi->query($query_per_jurusan);

// Populate the counts
while ($row = $per_jurusan_result->fetch_assoc()) {
    $jurusan = $row['jurusan'];
    $status_pekerjaan = $row['pekerjaan'];
    $count = $row['count'];
    if (isset($per_jurusan_counts[$jurusan])) {
        $per_jurusan_counts[$jurusan][$status_pekerjaan] = $count;
    }
}

// Query to fetch alumni who filled the questionnaire
$query_kuisioner = "
    SELECT
        a.nim as nim_alumni, a.nama, a.tahun_lulus, k.pekerjaan, k.level_tempat_bekerja as level_pekerjaan, k.jenis_tempat_bekerja as jenis_tempat_kerja, k.jurusan
    FROM
        alumni a
    JOIN
        kuisioner k ON a.nim = k.nim_alumni";
$kuisioner_result = $koneksi->query($query_kuisioner);

$kuisioner_data = [];
while ($row = $kuisioner_result->fetch_assoc()) {
    $kuisioner_data[] = $row;
}

// Query to fetch alumni ratings
$query_ratings = "
    SELECT
        alumni_nim,
        (etika + keahlian_bidang + kerjasama_tim + pengembangan_diri + kemampuan_bahasa_inggris + kemampuan_teknologi + kemampuan_komunikasi) / 7 AS rata_rata_rating
    FROM
        penilaian";
$ratings_result = $koneksi->query($query_ratings);

$ratings = [];
while ($row = $ratings_result->fetch_assoc()) {
    $ratings[] = $row;
}

// Handle search query
$search_query = "";
if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
}

// Search functionality
if ($search_query) {
    $query = "SELECT * FROM alumni WHERE nim LIKE ?";
    $stmt = $koneksi->prepare($query);
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("s", $search_param);
} else {
    $query = "SELECT * FROM alumni";
    $stmt = $koneksi->prepare($query);
}
$stmt->execute();
$alumni_result = $stmt->get_result();
$alumni_data = $alumni_result->fetch_all(MYSQLI_ASSOC);

// Pagination variables
$items_per_page = isset($_GET['items_per_page']) ? $_GET['items_per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;
$items_per_page = $items_per_page === 'all' ? $total_records : $items_per_page;

// Sorting variables
$sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'nim_alumni';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

// Validate column and order
$valid_columns = ['nim_alumni', 'nama', 'tahun_lulus', 'jurusan', 'pekerjaan', 'level_pekerjaan', 'jenis_tempat_kerja'];
if (!in_array($sort_column, $valid_columns)) {
    $sort_column = 'nim_alumni';
}
if (!in_array(strtoupper($sort_order), ['ASC', 'DESC'])) {
    $sort_order = 'ASC';
}
// Query to count total records
$total_query = "SELECT COUNT(*) as total FROM kuisioner";
$total_result = $koneksi->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

// Calculate total pages
$total_pages = $items_per_page === 'all' ? 1 : ceil($total_records / $items_per_page);

// Query to fetch alumni who filled the questionnaire with sorting and pagination
$query_kuisioner = "
    SELECT
        a.nim as nim_alumni, a.nama, a.tahun_lulus, k.pekerjaan, k.level_tempat_bekerja as level_pekerjaan, k.jenis_tempat_bekerja as jenis_tempat_kerja, k.jurusan
    FROM
        alumni a
    JOIN
        kuisioner k ON a.nim = k.nim_alumni
    ORDER BY $sort_column $sort_order
    LIMIT $offset, $items_per_page";
$kuisioner_result = $koneksi->query($query_kuisioner);

$kuisioner_data = [];
while ($row = $kuisioner_result->fetch_assoc()) {
    $kuisioner_data[] = $row;
}
$koneksi->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
</head>
<body class="bg-gray-100">
<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index_admin.php" class="text-white text-2xl font-bold">Admin Panel</a>
        <a href="logout.php" class="text-white hover:text-gray-400">Log Out</a>
    </div>
</nav>
<div class="container mx-auto my-10">
    <h1 class="text-3xl font-bold mb-5 text-center">Chart Hasil Pengisian Kuesioner</h1>

    <!-- Pie Chart Container for D3 Teknik Informatika -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h2 class="text-2xl font-bold mb-4">Distribusi Status Pekerjaan - D3 Teknik Informatika</h2>
        <canvas id="d3Chart"></canvas>
    </div>

    <!-- Pie Chart Container for S1 Teknik Informatika -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h2 class="text-2xl font-bold mb-4">Distribusi Status Pekerjaan - S1 Teknik Informatika</h2>
        <canvas id="s1Chart"></canvas>
    </div>

    <!-- Pie Chart Container for S2 Teknik Informatika -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h2 class="text-2xl font-bold mb-4">Distribusi Status Pekerjaan - S2 Teknik Informatika</h2>
        <canvas id="s2Chart"></canvas>
    </div>

    <!-- Data Table for Alumni who filled the Questionnaire -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h2 class="text-2xl font-bold mb-4">Alumni yang Mengisi Kuisioner</h2>
        
        <!-- Pagination and Sort Controls -->
        <div class="mb-4 flex justify-between items-center">
            <form method="GET" action="admin_dashboard.php" class="flex items-center space-x-4">
                <select name="items_per_page" class="px-4 py-2 border rounded" onchange="this.form.submit()">
                    <option value="10" <?= $items_per_page == 10 ? 'selected' : '' ?>>10</option>
                    <option value="25" <?= $items_per_page == 25 ? 'selected' : '' ?>>25</option>
                    <option value="50" <?= $items_per_page == 50 ? 'selected' : '' ?>>50</option>
                    <option value="all" <?= $items_per_page == 'all' ? 'selected' : '' ?>>All</option>
                </select>
                <input type="hidden" name="sort_column" value="<?= htmlspecialchars($sort_column) ?>">
                <input type="hidden" name="sort_order" value="<?= htmlspecialchars($sort_order) ?>">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Apply</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table id="kuisionerTable" class="min-w-full bg-white border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">
                            <a href="?sort_column=nim_alumni&sort_order=<?= $sort_order == 'ASC' ? 'DESC' : 'ASC' ?>&items_per_page=<?= $items_per_page ?>" class="text-blue-500 hover:underline">NIM</a>
                        </th>
                        <th class="border border-gray-300 px-4 py-2">
                            <a href="?sort_column=nama&sort_order=<?= $sort_order == 'ASC' ? 'DESC' : 'ASC' ?>&items_per_page=<?= $items_per_page ?>" class="text-blue-500 hover:underline">Nama</a>
                        </th>
                        <th class="border border-gray-300 px-4 py-2">
                            <a href="?sort_column=tahun_lulus&sort_order=<?= $sort_order == 'ASC' ? 'DESC' : 'ASC' ?>&items_per_page=<?= $items_per_page ?>" class="text-blue-500 hover:underline">Tahun Lulus</a>
                        </th>
                        <th class="border border-gray-300 px-4 py-2">Jurusan</th>
                        <th class="border border-gray-300 px-4 py-2">
                            <a href="?sort_column=pekerjaan&sort_order=<?= $sort_order == 'ASC' ? 'DESC' : 'ASC' ?>&items_per_page=<?= $items_per_page ?>" class="text-blue-500 hover:underline">Pekerjaan</a>
                        </th>
                        <th class="border border-gray-300 px-4 py-2">Level Pekerjaan</th>
                        <th class="border border-gray-300 px-4 py-2">Jenis Tempat Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kuisioner_data as $data): ?>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($data['nim_alumni']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($data['nama']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($data['tahun_lulus']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($data['jurusan']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($data['pekerjaan']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($data['level_pekerjaan']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($data['jenis_tempat_kerja']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Controls -->
        <div class="mt-4 flex justify-between items-center">
            <div>
                <span class="text-gray-600">Page <?= $page ?> of <?= $total_pages ?></span>
            </div>
            <div class="flex space-x-2">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>&items_per_page=<?= $items_per_page ?>&sort_column=<?= htmlspecialchars($sort_column) ?>&sort_order=<?= htmlspecialchars($sort_order) ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Previous</a>
                <?php endif; ?>
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?= $page + 1 ?>&items_per_page=<?= $items_per_page ?>&sort_column=<?= htmlspecialchars($sort_column) ?>&sort_order=<?= htmlspecialchars($sort_order) ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Data Table for Alumni Ratings -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Alumni yang Sudah Dinilai</h2>
        <div class="overflow-x-auto">
            <!-- Search Form -->
            <form method="POST" action="admin_dashboard.php" class="mb-6">
                <input type="text" name="search_query" placeholder="Search by NIM" class="px-4 py-2 border rounded w-full" value="<?= htmlspecialchars($search_query) ?>">
                <button type="submit" name="search" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Search</button>
            </form>
            <table id="penilaianTable" class="min-w-full bg-white border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">NIM Alumni</th>
                        <th class="border border-gray-300 px-4 py-2">Rata-rata Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ratings as $rating): ?>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($rating['alumni_nim']) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= number_format($rating['rata_rata_rating'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<footer class="bg-gray-700 text-white py-8">
    <div class="container mx-auto text-center md:text-left">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-start">
            <!-- Logo and Description -->
            <div class="mb-6 md:mb-0">
                <a href="index_admin.php" class="text-2xl font-bold text-white">TRACER STUDY</a>
                <p class="mt-4 text-gray-400">Connecting Alumni with Their Alma Mater</p>
            </div>
            <div class="mt-6 md:mt-0">
                <h3 class="text-lg font-semibold mb-2">Navigation</h3>
                <div class="flex space-x-4">
                    <ul>
                        <li><a href="index.php" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="../../add_job.php" class="text-gray-400 hover:text-white">Add Jobs?</a></li>
                        <li><a href="../../view_job_submit.php" class="text-gray-400 hover:text-white">View Submit Jobs?</a></li>
                        <li><a href="../../manage_alumni.php" class="text-gray-400 hover:text-white">Manage Alumni?</a></li>
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
    document.addEventListener("DOMContentLoaded", function() {
        const createPieChart = (chartId, data) => {
            const ctx = document.getElementById(chartId).getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        data: Object.values(data),
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                        hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        };

        createPieChart('d3Chart', <?= json_encode($per_jurusan_counts['d3_teknik_informatika']) ?>);
        createPieChart('s1Chart', <?= json_encode($per_jurusan_counts['s1_teknik_informatika']) ?>);
        createPieChart('s2Chart', <?= json_encode($per_jurusan_counts['s2_teknik_informatika']) ?>);
    });
</script>
<script>
    $(document).ready(function() {
        $('#kuisionerTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        $('#penilaianTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
</body>
</html>

