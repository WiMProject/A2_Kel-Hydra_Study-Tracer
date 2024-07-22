<?php
session_start();
include '../include/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_id = $_POST['jobs_id'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $tahun = $_POST['tahun'];
    $jurusan = $_POST['jurusan'];
    $file_path = '';

    // File upload handling
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_path = '../../uploads/' . $file_name;

        if (!move_uploaded_file($file_tmp, $file_path)) {
            die('Failed to upload file.');
        }
    }

    $query = "INSERT INTO apply_jobs (jobs_id, nim, nama, tahun, jurusan, file_path) VALUES ('$job_id', '$nim', '$nama', '$tahun', '$jurusan', '$file_path')";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['msg'] = 'Application submitted successfully!';
    } else {
        $_SESSION['msg'] = 'Failed to submit application: ' . mysqli_error($koneksi);
    }

    header('Location: index_alumni.php');
    exit();
}
?>
