<?php
session_start();
include 'connect.php';

$error_message = ''; // Inisialisasi variabel error_message

// Pastikan sudah login
if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit;
}

// Ambil id_properti dari parameter URL
if (isset($_GET['id_properti'])) {
    $id_properti = $_GET['id_properti'];
    
    // Query untuk mengambil informasi properti berdasarkan id_properti
    $query_properti = "SELECT * FROM informasi_properti WHERE id_properti = ?";
    $stmt = mysqli_prepare($conn, $query_properti);
    mysqli_stmt_bind_param($stmt, 'i', $id_properti);
    mysqli_stmt_execute($stmt);
    $result_properti = mysqli_stmt_get_result($stmt);
    
    // Pastikan properti ditemukan
    if (mysqli_num_rows($result_properti) > 0) {
        $properti = mysqli_fetch_assoc($result_properti);

        // Ambil informasi foto properti
        $query_foto = "SELECT foto FROM foto_properti WHERE id_properti = ?";
        $stmt_foto = mysqli_prepare($conn, $query_foto);
        mysqli_stmt_bind_param($stmt_foto, 'i', $id_properti);
        mysqli_stmt_execute($stmt_foto);
        $result_foto = mysqli_stmt_get_result($stmt_foto);
    } else {
        // Jika properti tidak ditemukan
        echo "Properti tidak ditemukan.";
        exit;
    }
} else {
    // Jika id_properti tidak ada dalam parameter URL
    echo "ID Properti tidak ditemukan.";
    exit;
}

if(isset($_POST['submit'])){
    $nama_properti = $_POST['judul'];
    $jenis_properti = $_POST['jenis'];
    $deskripsi = $_POST["deskripsi"];
    $Tipe = $_POST['Tipe'];
    $harga = $_POST['harga'];
    $alamat = $_POST['alamat'];
    $furnished = $_POST['furnished'];
    $jml_kamar = $_POST['kamar-tidur'];
    $jml_kmandi = $_POST['kamar-mandi'];
    $daerah = $_POST['daerah']; // Ambil nilai daerah dari form
    $link_google_maps = isset($_POST['link_google_maps']) ? $_POST['link_google_maps'] : '';

    // Update informasi properti
    $update_query = "UPDATE informasi_properti SET nama_properti = ?, jenis_properti = ?, deskripsi = ?, Tipe = ?, harga = ?, alamat = ?, furnished = ?, jml_kamar = ?, jml_kmandi = ?, daerah = ?, link_google_maps = ? WHERE id_properti = ?";
    $stmt_update = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt_update, 'sssissiiisii', $nama_properti, $jenis_properti, $deskripsi, $Tipe, $harga, $alamat, $furnished, $jml_kamar, $jml_kmandi, $daerah, $link_google_maps, $id_properti);
    
    if (mysqli_stmt_execute($stmt_update)) {
        // Jika update berhasil
        echo "<script>
            alert('Berhasil melakukan update informasi!');
            window.location.href='edit-properti-menu.php';
        </script>";
    } else {
        // Jika update gagal
        echo "<script>
            alert('Gagal melakukan update informasi!');
            window.location.href='edit-properti.php?id_properti=".$id_properti."';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="style/insert-properti.css" type="text/css">
    <link rel="stylesheet" href="style/edit-properti.css" type="text/css">
    <title>Khansa - Edit Properti</title>
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <div class="title">
            <h3>Edit Informasi Properti</h3>
        </div>
        <div class="gambar-properti">
            <?php
            while($row_foto = mysqli_fetch_assoc($result_foto)) {
                echo "<img src='" . $row_foto['foto'] . "' alt='Foto Properti'>";
            }
            ?>
        </div>
        <p style="font-size: 20px; color: red; margin-top: 10px; text-align: center;"><?php echo $error_message; ?></p>
        <div class="insert-info">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="judul">Nama Properti</label>
                <input class="jinput" type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($properti['nama_properti']); ?>">
                
                <label for="jenis">Jenis Properti</label>
                <select id="jenis" name="jenis" class="jinput">
                    <option value="Rumah" <?php if ($properti['jenis_properti'] == 'Rumah') echo 'selected'; ?>>Rumah</option>
                    <option value="Rumah Toko" <?php if ($properti['jenis_properti'] == 'Rumah Toko') echo 'selected'; ?>>Rumah Toko</option>
                    <option value="Rumah Susun" <?php if ($properti['jenis_properti'] == 'Rumah Susun') echo 'selected'; ?>>Rumah Susun</option>
                    <option value="Apartement" <?php if ($properti['jenis_properti'] == 'Apartement') echo 'selected'; ?>>Apartement</option>
                </select>
                
                <label for="alamat">Alamat</label>
                <input class="jinput" style="width: 100%;" type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($properti['alamat']); ?>">
                
                <label for="Tipe"> Tipe </label>
                <select id="Tipe" name="Tipe" class="jinput" required>
                <option value="40">40</option>
                <option value="45">45</option>
                <option value="90">90</option>
                </select>
                
                <label for="kamar-tidur">Jumlah Kamar Tidur</label>
                <input class="jinput" type="number" id="kamar-tidur" name="kamar-tidur" value="<?php echo $properti['jml_kamar']; ?>">
                
                <label for="kamar-mandi">Jumlah Kamar Mandi</label>
                <input class="jinput" type="number" id="kamar-mandi" name="kamar-mandi" value="<?php echo $properti['jml_kmandi']; ?>">
                
                <label for="furnished">Furnished</label>
                <select id="furnished" name="furnished" class="jinput">
                    <option value="Iya" <?php if ($properti['furnished'] == 'Iya') echo 'selected'; ?>>Iya</option>
                    <option value="Tidak" <?php if ($properti['furnished'] == 'Tidak') echo 'selected'; ?>>Tidak</option>
                </select>
                
                <label for="daerah">Daerah</label>
                <select id="daerah" name="daerah" class="jinput" required>
                    <option value="Cipta Karya" <?php if ($properti['daerah'] == 'Cipta Karya') echo 'selected'; ?>>Cipta Karya</option>
                    <option value="Purwodadi" <?php if ($properti['daerah'] == 'Purwodadi') echo 'selected'; ?>>Purwodadi</option>
                    <option value="Teropong" <?php if ($properti['daerah'] == 'Teropong') echo 'selected'; ?>>Teropong</option>
                </select>
                
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" class="jinput deskripsi"><?php echo htmlspecialchars($properti['deskripsi']); ?></textarea>
                
                <label for="harga">Harga</label>
                <input class="jinput" type="text" id="harga" name="harga" value="<?php echo $properti['harga']; ?>">

                <label for="foto1">Foto Rumah 1</label>
                <input type="file" name="foto1" id="foto1">
                <label for="foto2">Foto Rumah 2</label>
                <input type="file" name="foto2" id="foto2">
                <label for="foto3">Foto Rumah 3</label>
                <input type="file" name="foto3" id="foto3">
                
                <label for="link_google_maps"> Link Google Maps </label>
                <input class="jinput" type="text" id="link_google_maps" name="link_google_maps" value='<?php echo isset($_POST['link_google_maps']) ? htmlspecialchars($_POST['link_google_maps']) : ''; ?>'>
                
<input type="submit" name="submit" value="Submit" class="tombol-submit">
</form>
</div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
