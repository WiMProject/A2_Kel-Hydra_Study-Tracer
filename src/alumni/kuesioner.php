<?php
session_start();
include '../../koneksi.php';

// Check if user is logged in
if (!isset($_SESSION['nim'])) {
    header('Location: login_alumni.html');
    exit();
}

$error = '';
$success = '';

// Initialize variables
$nim_alumni = '';
$nama = '';
$jurusan = '';
$ipk_kelulusan = '';
$lama_studi = '';
$pekerjaan = '';
$jenis_tempat_bekerja = '';
$level_tempat_bekerja = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        // Get nim_alumni from POST data
        $nim_alumni = $_POST['nim_alumni'];
        
        // Check if record exists before trying to delete
        $check_sql = "SELECT * FROM kuisioner WHERE nim_alumni = '$nim_alumni'";
        $check_result = $koneksi->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Delete existing entry
            $delete_sql = "DELETE FROM kuisioner WHERE nim_alumni = '$nim_alumni'";
            if ($koneksi->query($delete_sql) === TRUE) {
                $success = "Jawaban anda berhasil dihapus. Anda bisa mengisi kembali.";
            } else {
                $error = "Error deleting entry: " . $koneksi->error;
            }
        } else {
            $error = "No existing entry found to delete.";
        }
    } else {
        // Get data from form
        $nim_alumni = $_POST['nim_alumni'];
        $nama = $_POST['nama'];
        $jurusan = $_POST['jurusan'];
        $ipk_kelulusan = $_POST['ipk_kelulusan'];
        $lama_studi = $_POST['lama_studi'];
        $pekerjaan = $_POST['pekerjaan'];
        $jenis_tempat_bekerja = $_POST['jenis_tempat_bekerja'];
        $level_tempat_bekerja = $_POST['level_tempat_bekerja'];

        // Check for existing entry
        $check_sql = "SELECT * FROM kuisioner WHERE nim_alumni = '$nim_alumni'";
        $check_result = $koneksi->query($check_sql);

        if ($check_result->num_rows > 0) {
            $error = "Anda sudah melakukan pengisian coba hapus jawaban sebelum mengisi kuesioner lagi!";
        } else {
            // Insert data into kuisioner table
            $sql = "INSERT INTO kuisioner (nim_alumni, nama, jurusan, ipk_kelulusan, lama_studi, pekerjaan, jenis_tempat_bekerja, level_tempat_bekerja)
                    VALUES ('$nim_alumni', '$nama', '$jurusan', '$ipk_kelulusan', '$lama_studi', '$pekerjaan', '$jenis_tempat_bekerja', '$level_tempat_bekerja')";

            if ($koneksi->query($sql) === TRUE) {
                $success = "Kuisioner berhasil disimpan.";
            } else {
                $error = "Error: " . $sql . "<br>" . $koneksi->error;
            }
        }
    }
}

// Query to get alumni data
$nim_alumni = $_SESSION['username'] ?? $_SESSION['nim'];
$sql = "SELECT * FROM alumni WHERE nim = '$nim_alumni'";
$result = $koneksi->query($sql);
if ($result->num_rows > 0) {
    $alumni = $result->fetch_assoc();
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner Profil Responden</title>
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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index_alumni.php" class="text-white text-2xl font-bold">TRACER STUDY</a>
        <button class="text-white md:hidden" id="mobile-menu-button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div class="hidden md:flex space-x-4">
            <a href="logout.php" class="text-white hover:text-gray-400">Logout</a>
        </div>
    </div>
    <div class="md:hidden" id="mobile-menu">
            <a href="logout.php" class="text-white hover:text-gray-400">Logout</a>
    </div>
</nav>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Kuesioner Profil Responden</h1>
        <?php if ($error != '') { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?= $error; ?>
            </div>
        <?php } elseif ($success != '') { ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?= $success; ?>
            </div>
        <?php } ?>

        <?php 
        // Check if the user has an existing entry
        $existing_entry_sql = "SELECT * FROM kuisioner WHERE nim_alumni = '$nim_alumni'";
        $existing_entry_result = $koneksi->query($existing_entry_sql);
        $has_existing_entry = $existing_entry_result->num_rows > 0;
        ?>

        <form action="kuesioner.php" method="POST">
            <input type="hidden" name="nim_alumni" value="<?= $nim_alumni; ?>">
            <input type="hidden" name="nama" value="<?= $_SESSION['nama']; ?>">
            <input type="hidden" name="jurusan" value="<?= $jurusan; ?>">
            <?php if ($has_existing_entry) { ?>
                <button type="submit" name="delete" class="bg-red-500 text-white px-4 py-2 rounded mb-4">Hapus Jawaban</button>
            <?php } ?>
            <table class="border-separate border-spacing-2 border border-slate-500 bg-white rounded-lg shadow-lg w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-center">No</th>
                        <th class="px-4 py-2 text-center">Indikator</th>
                        <th class="px-4 py-2 text-center">Respon</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border px-4 py-2 text-center">1</td>
                        <td class="border px-4 py-2">Tahun Kelulusan</td>
                        <td class="border px-4 py-2">
                            <select name="tahun_kelulusan" class="border rounded px-2 py-1 w-full">
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 text-center">2</td>
                        <td class="border px-4 py-2">Jurusan</td>
                        <td class="border px-4 py-2">
                            <select name="jurusan" class="border rounded px-2 py-1 w-full">
                                <option value="d3_teknik_informatika">D3 Teknik Informatika</option>
                                <option value="s1_teknik_informatika">S1 Teknik Informatika</option>
                                <option value="s2_teknik_informatika">S2 Teknik Informatika</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 text-center">3</td>
                        <td class="border px-4 py-2">IPK Kelulusan</td>
                        <td class="border px-4 py-2">
                            <input type="number" name="ipk_kelulusan" step="0.01" min="0" max="4" class="border rounded px-2 py-1 w-full" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 text-center">4</td>
                        <td class="border px-4 py-2">Lama Studi</td>
                        <td class="border px-4 py-2">
                            <select name="lama_studi" class="border rounded px-2 py-1 w-full">
                                <option value="1-3">1-3 tahun</option>
                                <option value="3-4">3-4 tahun</option>
                                <option value="4-5">4-5 tahun</option>
                                <option value=">5">>5 tahun</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 text-center">5</td>
                        <td class="border px-4 py-2">Pekerjaan</td>
                        <td class="border px-4 py-2">
                            <select name="pekerjaan" class="border rounded px-2 py-1 w-full">
                                <option value="bekerja">Bekerja</option>
                                <option value="tidak_bekerja">Tidak Bekerja</option>
                                <option value="melanjutkan_studi">Melanjutkan Studi</option>
                                <option value="wirausaha">Wirausaha</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 text-center">6</td>
                        <td class="border px-4 py-2">Jenis Tempat Bekerja</td>
                        <td class="border px-4 py-2">
                            <select name="jenis_tempat_bekerja" class="border rounded px-2 py-1 w-full">
                                <option value="instansi_pemerintah">Instansi Pemerintah</option>
                                <option value="lembaga_swasta">Lembaga Swasta</option>
                                <option value="perusahaan_swasta">Perusahaan Swasta</option>
                                <option value="usaha_sendiri">Usaha Sendiri</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 text-center">7</td>
                        <td class="border px-4 py-2">Level Tempat Bekerja</td>
                        <td class="border px-4 py-2">
                            <select name="level_tempat_bekerja" class="border rounded px-2 py-1 w-full">
                                <option value="lokal">Lokal</option>
                                <option value="nasional">Nasional</option>
                                <option value="multinasional_internasional">Multinasional/Internasional</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php
} else {
    echo "Alumni tidak ditemukan.";
}

$koneksi->close();
?>
