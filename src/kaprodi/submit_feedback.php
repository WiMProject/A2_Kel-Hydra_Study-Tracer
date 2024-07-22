<?php
session_start();
require('../../koneksi.php');

// Check if the user is logged in and is a kaprodi
if (!isset($_SESSION['nidn']) || $_SESSION['role'] != 'kaprodi') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $errors = [];
    $required_fields = ['alumni_nim', 'etika', 'keahlian_bidang', 'kerjasama_tim', 'pengembangan_diri', 'kemampuan_bahasa_inggris', 'kemampuan_teknologi', 'kemampuan_komunikasi', 'feedback'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = $field . ' is required';
        }
    }

    if (empty($errors)) {
        $alumni_id = mysqli_real_escape_string($koneksi, $_POST['alumni_nim']);
        $etika = mysqli_real_escape_string($koneksi, $_POST['etika']);
        $keahlian_bidang = mysqli_real_escape_string($koneksi, $_POST['keahlian_bidang']);
        $kerjasama_tim = mysqli_real_escape_string($koneksi, $_POST['kerjasama_tim']);
        $pengembangan_diri = mysqli_real_escape_string($koneksi, $_POST['pengembangan_diri']);
        $kemampuan_bahasa_inggris = mysqli_real_escape_string($koneksi, $_POST['kemampuan_bahasa_inggris']);
        $kemampuan_teknologi = mysqli_real_escape_string($koneksi, $_POST['kemampuan_teknologi']);
        $kemampuan_komunikasi = mysqli_real_escape_string($koneksi, $_POST['kemampuan_komunikasi']);
        $feedback = mysqli_real_escape_string($koneksi, $_POST['feedback']);

        try {
            // Insert data ke database
            $query = "INSERT INTO penilaian (alumni_nim, etika, keahlian_bidang, kerjasama_tim, pengembangan_diri, kemampuan_bahasa_inggris, kemampuan_teknologi, kemampuan_komunikasi, feedback, created_at) VALUES ('$alumni_id', '$etika', '$keahlian_bidang', '$kerjasama_tim', '$pengembangan_diri', '$kemampuan_bahasa_inggris', '$kemampuan_teknologi', '$kemampuan_komunikasi', '$feedback', NOW())";
            
            if (mysqli_query($koneksi, $query)) {
                $_SESSION['msg'] = "Feedback berhasil disubmit.";
            } else {
                throw new Exception(mysqli_error($koneksi));
            }
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $_SESSION['msg'] = "NIM '$alumni_id' sudah kamu beri feedback.";
            } else {
                $_SESSION['msg'] = "Terjadi kesalahan: " . $e->getMessage();
            }
        }
    } else {
        $_SESSION['msg'] = "Terjadi kesalahan: " . implode(', ', $errors);
    }
}

// Redirect back to feedback.php
header('Location: feedback.php');
exit();
?>
