<!-- add_kaprodi.php -->
<?php
session_start();
require('../include/koneksi.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    $_SESSION['msg'] = 'Anda harus login untuk mengakses halaman ini';
    header('Location: login_kaprodi.html');
    exit();
}

// Handle form submission to add new Kaprodi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $nidn = $_POST['nidn'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $jk = $_POST['jk'];
    $jurusan = $_POST['jurusan'];
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($koneksi, $password);
    $hash = password_hash($password, PASSWORD_BCRYPT); // Encrypt password

    // Perform database insertion
    $query = "INSERT INTO kaprodi (nama, nidn, username, email, jk, jurusan, password) VALUES ('$nama', '$nidn', '$username', '$email', '$jk', '$jurusan', '$hash')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header('Location: manage_kaprodi.php'); // Redirect to manage Kaprodi page after successful addition
        exit();
    } else {
        echo "Failed to add Kaprodi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Kaprodi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">

        <a href="index_admin.php" class="text-white text-2xl font-bold">Admin Panel</a>
        <a href="logout.php" class="text-white hover:text-gray-400">Log Out</a>
    </div>
</nav>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Add New Kaprodi</h1>

    <!-- Form to add new Kaprodi -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="max-w-lg mx-auto bg-white p-6 rounded shadow-md">
        <div class="mb-4">
            <label for="nama" class="block text-gray-700 font-bold mb-2">Nama</label>
            <input type="text" id="nama" name="nama" required class="w-full px-3 py-2 border rounded shadow appearance-none">
        </div>
        <div class="mb-4">
            <label for="nidn" class="block text-gray-700 font-bold mb-2">NIDN</label>
            <input type="text" id="nidn" name="nidn" required class="w-full px-3 py-2 border rounded shadow appearance-none">
        </div>
        <div class="mb-4">
            <label for="username" class="block text-gray-700 font-bold mb-2">Usermame</label>
            <input type="text" id="username" name="username" required class="w-full px-3 py-2 border rounded shadow appearance-none">
        </div>
        <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" required>
            </div>
        <div class="mb-4">
            <label for="jurusan" class="block text-gray-700 font-bold mb-2">Jurusan</label>
            <input type="text" id="jurusan" name="jurusan" required class="w-full px-3 py-2 border rounded shadow appearance-none">
        </div>
        <div class="mb-4">
            <label for="jk" class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
            <input type="text" id="jk" name="jk" required class="w-full px-3 py-2 border rounded shadow appearance-none">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" id="email" name="email" required class="w-full px-3 py-2 border rounded shadow appearance-none">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Kaprodi</button>
    </form>
</div>

</body>
</html>
