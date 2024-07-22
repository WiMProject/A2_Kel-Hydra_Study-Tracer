<!-- edit_kaprodi.php -->
<?php
session_start();
require('../include/koneksi.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login_admin.html');
    exit();
}

// Retrieve Kaprodi data based on ID from query string
if (!isset($_GET['nidn'])) {
    header('Location: manage_kaprodi.php'); // Redirect if ID is not provided or invalid
    exit();
}

$nidn = $_GET['nidn'];

// Query to fetch Kaprodi data by ID
$query = "SELECT * FROM kaprodi WHERE nidn = '$nidn'";
$result = mysqli_query($koneksi, $query);

// Check if Kaprodi data exists
if (!$result || mysqli_num_rows($result) !== 1) {
    header('Location: manage_kaprodi.php'); // Redirect if Kaprodi data not found
    exit();
}

$kaprodi = mysqli_fetch_assoc($result);

// Handle form submission to update Kaprodi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $jk = $_POST['jk'];
    $jurusan = $_POST['jurusan'];
    // Handle file upload for foto
    $foto = $_FILES['foto']['tmp_name'];
    $fotoContent = addslashes(file_get_contents($foto));

    // Perform database update
    $query = "UPDATE kaprodi SET 
                nama = '$nama', 
                username = '$username', 
                email = '$email', 
                password = '$password', 
                jk = '$jk', 
                jurusan = '$jurusan', 
                foto = '$fotoContent' 
              WHERE nidn = '$nidn'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header('Location: manage_kaprodi.php'); // Redirect to manage Kaprodi page after successful update
        exit();
    } else {
        echo "Failed to update Kaprodi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kaprodi</title>
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
    <h1 class="text-3xl font-bold mb-6">Edit Kaprodi</h1>

    <!-- Form to edit Kaprodi -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?nidn=' . $nidn; ?>" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white p-6 rounded shadow-md">
        <div class="mb-4">
            <label for="nama" class="block text-gray-700 font-bold mb-2">Nama</label>
            <input type="text" id="nama" name="nama" required class="w-full px-3 py-2 border rounded shadow appearance-none" value="<?php echo $kaprodi['nama']; ?>">
        </div>
        <div class="mb-4">
            <label for="username" class="block text-gray-700 font-bold mb-2">Username</label>
            <input type="text" id="username" name="username" required class="w-full px-3 py-2 border rounded shadow appearance-none" value="<?php echo $kaprodi['username']; ?>">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" id="email" name="email" required class="w-full px-3 py-2 border rounded shadow appearance-none" value="<?php echo $kaprodi['email']; ?>">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
            <input type="password" id="password" name="password" required class="w-full px-3 py-2 border rounded shadow appearance-none" value="<?php echo $kaprodi['password']; ?>">
        </div>
        <div class="mb-4">
            <label for="jk" class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
            <input type="text" id="jk" name="jk" required class="w-full px-3 py-2 border rounded shadow appearance-none" value="<?php echo $kaprodi['jk']; ?>">
        </div>
        <div class="mb-4">
            <label for="jurusan" class="block text-gray-700 font-bold mb-2">Jurusan</label>
            <input type="text" id="jurusan" name="jurusan" required class="w-full px-3 py-2 border rounded shadow appearance-none" value="<?php echo $kaprodi['jurusan']; ?>">
        </div>
        <div class="mb-4">
            <label for="foto" class="block text-gray-700 font-bold mb-2">Foto</label>
            <input type="file" id="foto" name="foto" class="w-full px-3 py-2 border rounded shadow appearance-none">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Kaprodi</button>
    </form>
</div>

</body>
</html>
