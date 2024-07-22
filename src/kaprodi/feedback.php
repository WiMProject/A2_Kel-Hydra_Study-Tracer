<?php
require('../../koneksi.php'); // Pastikan file koneksi.php sudah dibuat
session_start();
if (!$_SESSION['nidn']) {
    header('Location: login_kaprodi.html');
    exit();
}
// Ambil data alumni untuk ditampilkan dalam combobox
$query_alumni = "SELECT nim, nama FROM alumni";
$result_alumni = mysqli_query($koneksi, $query_alumni);

// Proses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumni_id = mysqli_real_escape_string($koneksi, $_POST['alumni_id']);
    $etika = mysqli_real_escape_string($koneksi, $_POST['etika']);
    $keahlian_bidang = mysqli_real_escape_string($koneksi, $_POST['keahlian_bidang']);
    $kerjasama_tim = mysqli_real_escape_string($koneksi, $_POST['kerjasama_tim']);
    $pengembangan_diri = mysqli_real_escape_string($koneksi, $_POST['pengembangan_diri']);
    $kemampuan_bahasa_inggris = mysqli_real_escape_string($koneksi, $_POST['kemampuan_bahasa_inggris']);
    $kemampuan_teknologi = mysqli_real_escape_string($koneksi, $_POST['kemampuan_teknologi']);
    $kemampuan_komunikasi = mysqli_real_escape_string($koneksi, $_POST['kemampuan_komunikasi']);
    $feedback = mysqli_real_escape_string($koneksi, $_POST['feedback']);

    $query_feedback = "INSERT INTO feedback (alumni_id, etika, keahlian_bidang, kerjasama_tim, pengembangan_diri, kemampuan_bahasa_inggris, kemampuan_teknologi, kemampuan_komunikasi, feedback) VALUES ('$alumni_id', '$etika', '$keahlian_bidang', '$kerjasama_tim', '$pengembangan_diri', '$kemampuan_bahasa_inggris', '$kemampuan_teknologi', '$kemampuan_komunikasi', '$feedback')";

    if (mysqli_query($koneksi, $query_feedback)) {
        $_SESSION['msg'] = "Feedback berhasil disimpan.";
    } else {
        $_SESSION['msg'] = "Gagal menyimpan feedback: " . mysqli_error($koneksi);
    }

    header("Location: submit_feedback.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Submit Feedback</title>
</head>
<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index_kaprodi.php" class="text-white text-2xl font-bold">TRACER STUDY</a>
        <button class="text-white md:hidden" id="mobile-menu-button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div class="hidden md:flex space-x-4">
            <a href="index_kaprodi.php" class="text-white hover:text-gray-400">Home</a>
            <a href="logout.php" class="text-white hover:text-gray-400">Log Out</a>
        </div>
    </div>
    <div class="md:hidden" id="mobile-menu">
            <a href="kaprodi.php" class="text-white hover:text-gray-400">Home</a>
            <a href="logout.php" class="text-white hover:text-gray-400">Log Out</a>
            </div>
</nav>
           
<body class="bg-gray-100">
    <div class="container mx-auto my-10">
        <h2 class="text-2xl font-bold mb-5">Submit Feedback</h2>
        <?php if (isset($_SESSION['msg'])): ?>
            <div class="bg-green-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></p>
            </div>
        <?php endif; ?>
        <form action="submit_feedback.php" method="POST" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="alumni_id" class="block text-gray-700 font-bold mb-2">Alumni:</label>
                <select id="alumni_id" name="alumni_nim" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Select alumni</option>
                    <?php while ($row = mysqli_fetch_assoc($result_alumni)): ?>
                        <option value="<?php echo $row['nim']; ?>">
                            <?= $row['nama']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="etika" class="block text-gray-700 font-bold mb-2">Etika:</label>
                <input type="number" id="etika" name="etika" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="keahlian_bidang" class="block text-gray-700 font-bold mb-2">Keahlian Bidang:</label>
                <input type="number" id="keahlian_bidang" name="keahlian_bidang" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="kerjasama_tim" class="block text-gray-700 font-bold mb-2">Kerjasama Tim:</label>
                <input type="number" id="kerjasama_tim" name="kerjasama_tim" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="pengembangan_diri" class="block text-gray-700 font-bold mb-2">Pengembangan Diri:</label>
                <input type="number" id="pengembangan_diri" name="pengembangan_diri" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="kemampuan_bahasa_inggris" class="block text-gray-700 font-bold mb-2">Kemampuan Bahasa Inggris:</label>
                <input type="number" id="kemampuan_bahasa_inggris" name="kemampuan_bahasa_inggris" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="kemampuan_teknologi" class="block text-gray-700 font-bold mb-2">Kemampuan Teknologi:</label>
                <input type="number" id="kemampuan_teknologi" name="kemampuan_teknologi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="kemampuan_komunikasi" class="block text-gray-700 font-bold mb-2">Kemampuan Komunikasi:</label>
                <input type="number" id="kemampuan_komunikasi" name="kemampuan_komunikasi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="feedback" class="block text-gray-700 font-bold mb-2">Feedback:</label>
                <textarea id="feedback" name="feedback" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
            </div>
        </form>
    </div>
    <!-- Footer -->
<footer class="bg-gray-700 text-white py-8">
    <div class="container mx-auto text-center md:text-left">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-start">
            <!-- Logo and Description -->
            <div class="mb-6 md:mb-0">
                <a href="index_kaprodi.php" class="text-2xl font-bold text-white">TRACER STUDY</a>
                <p class="mt-4 text-gray-400">Connecting Alumni with Their Alma Mater</p>
            </div>
            <!-- Social Media Links -->
            <div class="mt-6 md:mt-0">
                <h3 class="text-lg font-semibold mb-2">Navigation</h3>
                <div class="flex space-x-4">
                    <ul>
                        <li><a href="index_kaprodi.php" class="text-gray-400 hover:text-white">Home</a></li>
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
</body>
</html>
