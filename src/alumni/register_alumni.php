<?php
require('../include/koneksi.php'); // File koneksi ke database
session_start();

$error = '';

// Proses register
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = stripslashes($_POST['nim']);
    $nim = mysqli_real_escape_string($koneksi, $nim);
    $nama = stripslashes($_POST['nama']);
    $nama = mysqli_real_escape_string($koneksi, $nama);
    $prodi = stripslashes($_POST['jurusan']);
    $prodi = mysqli_real_escape_string($koneksi, $prodi);
    $ipk = stripslashes($_POST['ipk']);
    $ipk = mysqli_real_escape_string($koneksi, $ipk);
    $tahun_lulus = stripslashes($_POST['tahun_lulus']);
    $tahun_lulus = mysqli_real_escape_string($koneksi, $tahun_lulus);
    $jk = stripslashes($_POST['jk']);
    $jk = mysqli_real_escape_string($koneksi, $jk);
    $telepon = stripslashes($_POST['telepon']);
    $telepon = mysqli_real_escape_string($koneksi, $telepon);
    $email = stripslashes($_POST['email']);
    $email = mysqli_real_escape_string($koneksi, $email);
    $username = stripslashes($_POST['username']);
    $username = mysqli_real_escape_string($koneksi, $username);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($koneksi, $password);
    $hash = password_hash($password, PASSWORD_BCRYPT); // Encrypt password

    // Handle file upload
    $foto = NULL;
    if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0) {
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
    }

    if (!empty(trim($nim)) && !empty(trim($nama)) && !empty(trim($prodi)) && !empty(trim($ipk)) && !empty(trim($tahun_lulus)) && !empty(trim($jk)) && !empty(trim($username)) && !empty(trim($password))) {
        $query = "SELECT * FROM alumni WHERE username = '$username'";
        $result = mysqli_query($koneksi, $query);
        $rows = mysqli_num_rows($result);

        if ($rows == 0) {
            $sql = "INSERT INTO alumni (nim, nama, jurusan, ipk, tahun_lulus, jk, telepon, foto, email, username, password, role) 
                    VALUES ('$nim', '$nama', '$prodi', '$ipk', '$tahun_lulus', '$jk', '$telepon', '$foto', '$email', '$username', '$hash', 'alumni')";

            if ($koneksi->query($sql) === TRUE) {
                header('Location: login_alumni.html');
                exit();
            } else {
                $error = 'Registrasi Gagal!';
            }
        } else {
            $error = 'Nim sudah ada masukan nim dengan benar!';
        }
    } else {
        $error = 'Data tidak bole kosong!';
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

    <title>Register Alumni</title>
</head>

<body class="bg-gray-100 text-gray-900 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-lg mx-auto">
        <form class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4" action="register_alumni.php" method="POST" enctype="multipart/form-data">
            <h4 class="text-3xl font-semibold text-center mb-6">Register Alumni</h4>
            <?php if ($error != '') { ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <?= $error; ?>
                </div>
            <?php } ?>
            <div class="mb-4">
                <label for="nim" class="block text-gray-700 text-sm font-semibold mb-2">NIM</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nim" name="nim" required>
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 text-sm font-semibold mb-2">Nama</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama" name="nama" required>
            </div>
            <div class="mb-4">
                <label for="jurusan" class="block text-gray-700 text-sm font-semibold mb-2">Jurusan</label>
                <select name="jurusan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="d3_teknik_informatika">D3 Teknik Informatika</option>
                    <option value="s1_teknik_informatika">S1 Teknik Informatika</option>
                    <option value="s2_teknik_informatika">S2 Teknik Informatika</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="ipk" class="block text-gray-700 text-sm font-semibold mb-2">IPK</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ipk" name="ipk" required>
            </div>
            <div class="mb-4">
                <label for="tahun_lulus" class="block text-gray-700 text-sm font-semibold mb-2">Tahun Lulus</label>
                <select name="tahun_lulus" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="jk" class="block text-gray-700 text-sm font-semibold mb-2">Jenis Kelamin</label>
                <select name="jk" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="L">Laki - Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="telepon" class="block text-gray-700 text-sm font-semibold mb-2">Telepon</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="telepon" name="telepon">
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-gray-700 text-sm font-semibold mb-2">Foto</label>
                <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="foto" name="foto">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email">
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Username</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register</button>
                <a href="login_alumni.html" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Already have an account?</a>
            </div>
        </form>
    </div>

</body>

</html>
