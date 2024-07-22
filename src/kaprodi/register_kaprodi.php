<?php
require('../include/koneksi.php'); // File koneksi ke database
session_start();

$error = '';

// Proses register
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nidn = stripslashes($_POST['nidn']);
    $nidn = mysqli_real_escape_string($koneksi, $nidn);
    $nama = stripslashes($_POST['nama']);
    $nama = mysqli_real_escape_string($koneksi, $nama);
    $prodi = stripslashes($_POST['jurusan']);
    $prodi = mysqli_real_escape_string($koneksi, $prodi);
    $jk = stripslashes($_POST['jk']);
    $jk = mysqli_real_escape_string($koneksi, $jk);
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

    if (!empty(trim($nidn)) && !empty(trim($nama)) && !empty(trim($prodi)) && !empty(trim($jk)) && !empty(trim($username)) && !empty(trim($password))) {
        $query = "SELECT * FROM kaprodi WHERE username = '$username'";
        $result = mysqli_query($koneksi, $query);
        $rows = mysqli_num_rows($result);

        if ($rows == 0) {
            $sql = "INSERT INTO kaprodi (nidn, nama, jurusan, jk, foto, email, username, password, role) 
                    VALUES ('$nidn', '$nama', '$prodi', '$jk', '$foto', '$email', '$username', '$hash', 'kaprodi')";

            if ($koneksi->query($sql) === TRUE) {
                header('Location: login_kaprodi.html');
                exit();
            } else {
                $error = 'Registrasi Gagal!';
            }
        } else {
            $error = 'Nidn sudah ada masukan nim dengan benar!';
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

    <title>Register Kaprodi</title>
</head>

<body class="bg-gray-100 text-gray-900 flex items-center justify-center h-screen">

    <div class="w-full max-w-lg mx-auto">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="register_kaprodi.php" method="POST" enctype="multipart/form-data">
            <h4 class="text-2xl font-bold text-center mb-4">Register Kaprodi</h4>
            <?php if ($error != '') { ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <?= $error; ?>
                </div>
            <?php } ?>
            <div class="mb-4">
                <label for="nidn" class="block text-gray-700 text-sm font-bold mb-2">NIDN</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nidn" name="nidn" required>
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama" name="nama" required>
            </div>
            <div class="mb-4">
                <label for="jurusan" class="block text-gray-700 text-sm font-bold mb-2">Jurusan</label>
                <select name="jurusan" class="border rounded px-2 py-1">
                                <option value="Teknik Informatika">Teknik Informatika</option>
                            </select>
            </div>
            <div class="mb-4">
                <label for="jk" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin (L/P)</label>
                <select name="tahun_lulus" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="L">Laki - Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="mb-4">
            <label for="foto" class="block text-gray-700 text-sm font-bold mb-2">Foto</label>
                <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="foto" name="foto">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email">
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
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