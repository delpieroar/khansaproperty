<?php 
session_start();
include 'connect.php';
$error_message = '';

if (!isset($_SESSION['id'])) {
    header('location:login.php');
    exit();
}

$id = $_SESSION['id'];
$data_user = mysqli_query($conn, "SELECT * FROM pengguna WHERE id_pengguna = '$id'");

if (mysqli_num_rows($data_user) == 0) {
    session_destroy();
    header('Location: login.php');
    exit();
}

if (isset($_SESSION['id'])) {
    $level = $_SESSION['level'];
    if ($level == 'admin') {
        header('location:index.php');
    }
} else {
    header('location:login.php');
}

$query = mysqli_query($conn, "SELECT * FROM informasi_properti WHERE id_pengguna = '$id'");
$i = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="style/management.css" type="text/css">
    <title>Khansa - Management</title>
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <div class="title">
            <h1> Properti</h1>
        </div>
        <div class="tombol-management">
            <a class="tombol-insert" href="insert-properti.php">Insert Informasi Properti</a>
            <a class="tombol-insert" href="edit-properti-menu.php">Informasi Properti</a>
        </div>
        <?php if (mysqli_num_rows($query) < 1): ?>
            <h3>Belum ada data properti di dalam database!</h3>
        <?php else: ?>
            <table class="informasi-rumah">
                <tr>
                    <th>No</th>
                    <th>ID Properti</th>
                    <th>Nama Properti</th>
                    <th>Jenis Properti</th>
                    <th>Tipe</th>
                    <th>Kamar Tidur</th>
                    <th>Kamar Mandi</th>
                    <th>Furnihsed</th>
                    <th>Alamat</th>
                    <th>Harga</th>
                    <th>Disetujui</th>
                    <th>Tanggal Post</th>
                    <th>Aksi</th>
                </tr>
                <?php while ($hasil = mysqli_fetch_array($query)) {
                    echo "
                        <tr>
                            <td>$i</td>
                            <td>$hasil[id_properti]</td>
                            <td><a class='nama-properti' href=detail.php?id_properti=$hasil[id_properti]>$hasil[nama_properti]</a></td>
                            <td>$hasil[jenis_properti]</td>
                            <td>$hasil[Tipe]</td>
                            <td>$hasil[jml_kamar]</td>
                            <td>$hasil[jml_kmandi]</td>
                            <td>$hasil[furnished]</td>
                            <td>$hasil[alamat]</td>
                            <td>$hasil[harga]</td>
                            <td>$hasil[acceptable]</td>
                            <td>$hasil[tanggal_post]</td>
                            <td><a class='tombol-insert kecil' href=edit-properti.php?id_properti=$hasil[id_properti]>Edit</a></td>
                        <tr>
                    ";
                    $i++;
                }
                ?>
            </table>
        <?php endif ?>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
