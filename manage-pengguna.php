<?php 
session_start();
include ('connect.php');
$error_message ='';

if(isset($_SESSION['id'])){
    $level = $_SESSION['level'];
    if($level == 'reguler'){
        header('location:index.php');
    }
}else{
    header('location:login.php');
}

$id = $_SESSION['id']; 
$query = mysqli_query($conn,"
    SELECT pengguna.*, booking.id_properti 
    FROM pengguna 
    LEFT JOIN booking ON pengguna.id_pengguna = booking.id_pengguna 
    WHERE pengguna.level = 'reguler'
");
$i = 1;
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
            <h1>Manajemen Pengguna</h1>
        </div>
        <div class="tombol-management">
            <a class="tombol-insert" href="insert-properti.php">Insert Properti</a>
            <a class="tombol-insert" href="manage-info.php">Manajemen Properti</a>
            <a class="tombol-insert" href="penyetujuan.php">Penyetujuan Properti</a>
            <a class="tombol-insert" href="manage-pengguna.php">Manajemen Pengguna</a>
        </div>
        <?php if(mysqli_num_rows($query) < 1): ?>
            <h3>Belum ada data pengguna di dalam database!</h3>
        <?php else: ?>
            <table class="informasi-rumah">
                <tr>
                    <th>No</th>
                    <th>ID Pengguna</th>
                    <th>Tanggal Buat</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. HP (+62)</th>
                    <th>Status</th>
                    <th>Booking</th>
                    <th>Aksi</th>
                </tr>
                <?php while($hasil=mysqli_fetch_array($query)){
                    echo "
                        <tr>
                            <td>$i</td>
                            <td>$hasil[id_pengguna]</td>
                            <td>$hasil[tanggal_buat]</td>
                            <td>$hasil[nama]</td>
                            <td>$hasil[email]</td>
                            <td>$hasil[no_hp]</td>
                            <td>".ucfirst($hasil['keadaan'])."</td>
                            <td>".($hasil['id_properti'] ? $hasil['id_properti'] : 'Tidak ada')."</td>
                    ";
                    if($hasil['keadaan'] == 'aktif'){
                        echo "<td><button class='tombol-hapus kecil hapus-info' onclick=blokir($hasil[id_pengguna]) name=Delete Value=Delete>Blokir</button> ";
                    }else{
                        echo "<td><button class='tombol-insert kecil hapus-info' onclick=aktif($hasil[id_pengguna]) name=Delete Value=Delete>Unblokir</button> ";
                    }
                    echo "<a class='tombol-insert kecil' href='edit-password.php?id_pengguna=$hasil[id_pengguna]' style='font-size: 14px;'>Edit Password</a></td>";
                    echo "<tr>";
                    $i++;
                }
                ?>
            <?php endif ?>
        </table>
    </main>
    <?php include 'footer.php'; ?>
    <script src="script/hapus.js"></script>
</body>
</html>
