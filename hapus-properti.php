<?php
session_start();
include 'connect.php';

// Pastikan sudah login
if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit;
}

// Pastikan yang login adalah admin
if ($_SESSION['level'] !== 'admin') {
    header('location: index.php');
    exit;
}

// Pastikan ID properti ada di URL
if (!isset($_GET['id_properti'])) {
    header('location: manage-info.php');
    exit;
}

$id_properti = $_GET['id_properti'];

// Hapus foto properti yang terkait dari database
$query_foto = "DELETE FROM foto_properti WHERE id_properti = ?";
$stmt_foto = $conn->prepare($query_foto);
$stmt_foto->bind_param("i", $id_properti);

if ($stmt_foto->execute()) {
    // Hapus properti dari database setelah menghapus foto terkait
    $query_properti = "DELETE FROM informasi_properti WHERE id_properti = ?";
    $stmt_properti = $conn->prepare($query_properti);
    $stmt_properti->bind_param("i", $id_properti);

    if ($stmt_properti->execute()) {
        // Jika berhasil, arahkan kembali ke halaman manajemen properti
        header('location: manage-info.php?status=success&message=Properti berhasil dihapus');
    } else {
        // Jika gagal, tampilkan pesan error
        header('location: manage-info.php?status=error&message=Gagal menghapus properti');
    }

    $stmt_properti->close();
} else {
    // Jika gagal menghapus foto, tampilkan pesan error
    header('location: manage-info.php?status=error&message=Gagal menghapus foto properti');
}

$stmt_foto->close();
$conn->close();
?>
