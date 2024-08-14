<?php
session_start();
include 'connect.php';
$error_message = "";

// Cek apakah ada sesi yang aktif
if (!isset($_SESSION['id'])) {
    header('location:login.php');
    exit();
}

$id = $_SESSION['id']; // Inisialisasi variabel $id

if (isset($_POST['submit'])) {
    // Pengecekan ulang apakah akun pengguna masih ada di database
    $data_user = mysqli_query($conn, "SELECT * FROM pengguna WHERE id_pengguna = '$id'");
    if (mysqli_num_rows($data_user) == 0) {
        session_destroy();
        header('Location: login.php');
        exit();
    }

    // Proses penyimpanan data properti
    // Tangkap data dari form
    $nama_properti = $_POST['judul'];
    $jenis_properti = $_POST['jenis'];
    $deskripsi = $_POST["deskripsi"];
    $Tipe = $_POST['Tipe'];
    $harga = $_POST['harga'];
    $alamat = $_POST['alamat'];
    $furnished = $_POST['furnished'];
    $jml_kamar = $_POST['kamar-tidur'];
    $jml_kmandi = $_POST['kamar-mandi'];
    $daerah = $_POST['daerah']; // Tambahkan daerah
    $link_google_maps = $_POST['link_google_maps']; // Menambahkan ini
    $acceptable = "Tidak";
    $result = mysqli_query($conn, "SELECT * FROM informasi_properti WHERE nama_properti = '$nama_properti'") or die(mysqli_error($conn));
    $get_nama = mysqli_num_rows($result);

    // Validasi apakah nama properti sudah digunakan oleh seller lain
    if ($get_nama > 0) {
        $error_message = "NAMA PROPERTI TELAH DIGUNAKAN SELLER LAIN!";
    } else {
        // Validasi ekstensi foto
        $foto1tipe = $_FILES['foto1']['type'];
        $foto2tipe = $_FILES['foto2']['type'];
        $foto3tipe = $_FILES['foto3']['type'];
        if ((($foto1tipe == 'image/png') || ($foto1tipe == 'image/jpg') || ($foto1tipe == 'image/jpeg')) && (($foto2tipe == 'image/png') || ($foto2tipe == 'image/jpeg') || ($foto2tipe == 'image/jpg')) && (($foto3tipe == 'image/png') || ($foto3tipe == 'image/jpg') || ($foto3tipe == 'image/jpeg'))) {
            // Jika ekstensi foto sesuai, lakukan penyimpanan data properti
            $query = "INSERT INTO informasi_properti (id_pengguna, nama_properti, jenis_properti, deskripsi, Tipe, harga, alamat, furnished, jml_kamar, jml_kmandi, daerah, link_google_maps, acceptable, tanggal_post) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())";
            
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "isssiisiiisss", $id, $nama_properti, $jenis_properti, $deskripsi, $Tipe, $harga, $alamat, $furnished, $jml_kamar, $jml_kmandi, $daerah, $link_google_maps, $acceptable);
            
            // Eksekusi query
            if (mysqli_stmt_execute($stmt)) {
                $id_properti = mysqli_insert_id($conn);

                // Simpan foto ke direktori
                $directory = "galery";
                $foto1 = "P" . $id_properti . "1.png";
                $foto2 = "P" . $id_properti . "2.png";
                $foto3 = "P" . $id_properti . "3.png";

                $foto_temp1 = $_FILES['foto1']['tmp_name'];
                $foto_temp2 = $_FILES['foto2']['tmp_name'];
                $foto_temp3 = $_FILES['foto3']['tmp_name'];

                move_uploaded_file($foto_temp1, $directory . "/" . $foto1);
                move_uploaded_file($foto_temp2, $directory . "/" . $foto2);
                move_uploaded_file($foto_temp3, $directory . "/" . $foto3);

                $path_foto1 = $directory . "/" . $foto1;
                $path_foto2 = $directory . "/" . $foto2;
                $path_foto3 = $directory . "/" . $foto3;

                // Simpan path foto ke dalam tabel foto_properti
                mysqli_query($conn, "INSERT INTO foto_properti (id_properti,foto) values ('$id_properti','$path_foto1')");
                mysqli_query($conn, "INSERT INTO foto_properti (id_properti,foto) values ('$id_properti','$path_foto2')");
                mysqli_query($conn, "INSERT INTO foto_properti (id_properti,foto) values ('$id_properti','$path_foto3')");

                // Redirect setelah data berhasil disimpan
                echo "
                    <script>
                        alert('Insert data berhasil!');
                        window.location.href='edit-properti-menu.php';
                    </script>
                ";
            } else {
                // Jika terjadi kesalahan saat eksekusi query
                $error_message = "Gagal memasukkan data properti: " . mysqli_error($conn);
            }
        } else {
            // Jika ekstensi foto tidak sesuai
            $error_message = "EKSTENSI FOTO HARUS PNG, JPG, ATAU JPEG";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php' ?>
    <link rel="stylesheet" href="style/insert-properti.css" type="text/css">
    <style>
        .tombol-submit {
            color: white;
            margin-top: 25px;
            background-color: #48dbfb; /* Warna latar belakang */
            font-weight: bold;
            width: 50%; /* Lebar tombol */
            padding: 15px 10px; /* Padding tombol */
            border-radius: 8px; /* Sudut border */
            border: none; /* Tanpa border */
            font-size: 20px; /* Ukuran font */
            cursor: pointer; /* Kursor berubah saat diarahkan */
            transition: background-color 0.3s; /* Transisi perubahan warna latar belakang */
        }

        .tombol-submit:hover {
            background-color: #0abde3; /* Warna latar belakang saat dihover */
        }
    </style>
    <title>Khansa - Insert Selling Information</title>
</head>
<body>
<?php include 'nav.php' ?>
<main>
    <div class="title">
        <h3>Masukan Informasi Properti</h3>
    </div>
    <p style="font-size: 20px; color: red; margin-top: 10px; text-align: center;"><?php echo $error_message; ?></p>
    <div class="insert-info">
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="judul"> Nama Properti </label>
            <input class="jinput" type="text" id="judul" name="judul" required>
            <label for="jenis"> Jenis Properti </label>
            <select id="jenis" name="jenis" class="jinput" required>
                <option value="Rumah">Rumah</option>
                <option value="Rumah Toko">Rumah Toko</option>
                <option value="Rumah Susun">Rumah Susun</option>
                <option value="Apartement">Apartement</option>
            </select>
            <label for="alamat"> Alamat </label>
            <input class="jinput" style="width: 100%;" type="text" id="alamat" name="alamat" required>
            <label for="Tipe"> Tipe </label>
            <select id="Tipe" name="Tipe" class="jinput" required>
            <option value="40">40</option>
            <option value="45">45</option>
            <option value="90">90</option>
            </select>
            <label for="kamar-tidur">Jumlah Kamar Tidur</label>
            <input class="jinput" type="number" id="kamar-tidur" name="kamar-tidur">
            <label for="kamar-mandi">Jumlah Kamar Mandi</label>
            <input class="jinput" type="number" id="kamar-mandi" name="kamar-mandi">
            <label for="furnished"> Furnished</label>
            <select id="furnished" name="furnished" class="jinput" required>
                <option value="Iya">Iya</option>
                <option value="Tidak">Tidak</option>
            </select>
            <label for="daerah"> Daerah </label>
            <select id="daerah" name="daerah" class="jinput" required>
                <option value="Cipta Karya">Cipta Karya</option>
                <option value="Purwodadi">Purwodadi</option>
                <option value="Teropong">Teropong</option>
            </select>
            <label for="deskripsi"> Deskripsi </label>
            <textarea name="deskripsi" class="jinput deskripsi" placeholder="Jumlah Kamar, Furnished, Kondisi Rumah, DLL" required></textarea>
            <label for="harga"> Harga </label>
            <input class="jinput" type="text" id="harga" name="harga" required>
            <label for="foto1">Foto Rumah 1</label>
            <input type="file" name="foto1" id="foto1" required>
            <label for="foto2">Foto Rumah 2</label>
            <input type="file" name="foto2" id="foto2" required>
            <label for="foto3">Foto Rumah 3</label>
            <input type="file" name="foto3" id="foto3" required>
            <label for="link_google_maps">Link Google Maps</label>
            <input class="jinput" type="text" id="link_google_maps" name="link_google_maps" required>
            <input type="submit" name="submit" value="Submit" class="tombol-submit">
        </form>
    </div>
</main>
</body>
</html>
