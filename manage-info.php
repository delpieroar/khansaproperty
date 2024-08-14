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

$error_message = '';
$id_admin = $_SESSION['id']; // Simpan ID admin
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="style/management.css" type="text/css">
    <link rel="stylesheet" href="style/hapus.css" type="text/css">

    <title>Khansa - Management</title>
</head>

<body>
    <?php include 'nav.php'; ?>
    <main>
        <div class="title">
            <h1>Manajemen Informasi Properti</h1>
        </div>
        <div class="tombol-management">
            <a class="tombol-insert" href="insert-properti.php">Insert Properti</a>
            <a class="tombol-insert" href="manage-info.php">Manajemen Properti</a>
            <a class="tombol-insert" href="penyetujuan.php">Penyetujuan Properti</a>
            <a class="tombol-insert" href="manage-pengguna.php">Manajemen Pengguna</a>
        </div>
        <table class="informasi-rumah">
            <tr>
                <th>No</th>
                <th>ID Properti</th>
                <th>ID Pengguna</th>
                <th>Nama Properti</th>
                <th>Jenis Properti</th>
                <th>Tipe</th>
                <th>Kamar Tidur</th>
                <th>Kamar Mandi</th>
                <th>Furnished</th>
                <th>Alamat</th>
                <th>Harga</th>
                <th>Disetujui</th>
                <th>Tanggal Post</th>
                <th>Status Booking</th>
                <th>Aksi</th>
            </tr>
            <?php
            $query = mysqli_query($conn, "SELECT * FROM informasi_properti WHERE id_pengguna IN (SELECT id_pengguna FROM pengguna WHERE keadaan = 'aktif') AND acceptable = 'Iya'");
            $i = 1;
            while ($hasil = mysqli_fetch_array($query)) {
                $status_booking = $hasil['status_booking'] == 'Available' ? 'Tersedia' : 'Terbooking';
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $hasil['id_properti']; ?></td>
                    <td><?php echo $hasil['id_pengguna']; ?></td>
                    <td><a class="nama-properti" href="detail.php?id_properti=<?php echo $hasil['id_properti']; ?>"><?php echo $hasil['nama_properti']; ?></a></td>
                    <td><?php echo $hasil['jenis_properti']; ?></td>
                    <td><?php echo $hasil['Tipe']; ?></td>
                    <td><?php echo $hasil['jml_kamar']; ?></td>
                    <td><?php echo $hasil['jml_kmandi']; ?></td>
                    <td><?php echo $hasil['furnished']; ?></td>
                    <td><?php echo $hasil['alamat']; ?></td>
                    <td><?php echo $hasil['harga']; ?></td>
                    <td><?php echo $hasil['acceptable']; ?></td>
                    <td><?php echo $hasil['tanggal_post']; ?></td>
                    <td><?php echo $status_booking; ?></td>
                    <td>
                        <button class="tombol-edit kecil" onclick="editProperty(<?php echo $hasil['id_properti']; ?>)" name="Edit" value="Edit">Edit</button>
                        <button class="tombol-hapus kecil hapus-info" onclick="delconfirm(<?php echo $hasil['id_properti']; ?>)" name="Delete" value="Delete">Hapus</button>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </table>
    </main>
    <?php include 'footer.php'; ?>
    <script src="script/hapus.js"></script>
    <script>
        function editProperty(id) {
            window.location.href = 'edit-properti-admin.php?id_properti=' + id;
        }

        function delconfirm(id) {
            if (confirm('Apakah Anda yakin ingin menghapus properti ini?')) {
                window.location.href = 'hapus-properti.php?id_properti=' + id;
            }
        }
    </script>
</body>

</html>
