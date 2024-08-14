<?php
session_start();
include 'connect.php';

$error_message = ''; // Inisialisasi variabel error_message

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

$id_admin = $_SESSION['id']; // Simpan ID admin

// Ambil id_properti dari parameter URL
if (isset($_GET['id_properti'])) {
    $id_properti = $_GET['id_properti'];
    
    // Query untuk mengambil informasi properti berdasarkan id_properti
    $query = mysqli_query($conn, "SELECT * FROM informasi_properti WHERE id_properti = '$id_properti'");
    $properti = mysqli_fetch_assoc($query);
    
    // Jika properti ditemukan, lanjutkan dengan proses edit
    if ($properti) {
        // Proses edit properti
        // Misalnya, Anda dapat menampilkan form untuk mengedit properti di sini
        // Contoh: echo "<input type='text' name='nama_properti' value='" . $properti['nama_properti'] . "'>";
    } else {
        // Jika properti tidak ditemukan
        echo "Properti tidak ditemukan.";
    }
} else {
    // Jika id_properti tidak ada dalam parameter URL
    echo "ID Properti tidak ditemukan.";
}
?>

<?php
    $id_properti = $_GET['id_properti']; 
    $info = mysqli_query($conn,"SELECT * FROM informasi_properti WHERE id_properti = '$id_properti'");
    $query_foto = mysqli_query($conn,"SELECT foto FROM foto_properti WHERE id_properti = '$id_properti'");
?>

<?php 
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
        $daerah = $_POST['daerah']; // Pastikan 'daerah' diambil dari form

        $cek_nama = mysqli_fetch_array(mysqli_query($conn,"SELECT nama_properti FROM informasi_properti WHERE id_properti = '$id_properti'"));
        $error_message = '';

        $cekFormatFoto1 = true;
        $cekFormatFoto2 = true;
        $cekFormatFoto3 = true;

        $directory = "galery";

        if($_FILES['foto1']['name'] != ''){
            $foto1tipe = $_FILES['foto1']['type'];
            if(!($foto1tipe == 'image/png' or $foto1tipe == 'image/jpeg' or $foto1tipe == 'image/jpg')){
                $cekFormatFoto1 = false;
            } else {
                $foto1_ext = pathinfo($_FILES['foto1']['name'], PATHINFO_EXTENSION);
                $foto1 = "P".$id_properti."1.".$foto1_ext;
                $foto_temp1 = $_FILES['foto1']['tmp_name'];
                move_uploaded_file($foto_temp1, $directory."/".$foto1);
                // Update path foto dalam database
                mysqli_query($conn, "UPDATE foto_properti SET foto='$directory/$foto1' WHERE id_properti='$id_properti' AND foto LIKE '%P".$id_properti."1.%'");
            }
        }

        if($_FILES['foto2']['name'] != ''){
            $foto2tipe = $_FILES['foto2']['type'];
            if(!($foto2tipe == 'image/png' or $foto2tipe == 'image/jpeg' or $foto2tipe == 'image/jpg')){
                $cekFormatFoto2 = false;
            } else {
                $foto2_ext = pathinfo($_FILES['foto2']['name'], PATHINFO_EXTENSION);
                $foto2 = "P".$id_properti."2.".$foto2_ext;
                $foto_temp2 = $_FILES['foto2']['tmp_name'];
                move_uploaded_file($foto_temp2, $directory."/".$foto2);
                // Update path foto dalam database
                mysqli_query($conn, "UPDATE foto_properti SET foto='$directory/$foto2' WHERE id_properti='$id_properti' AND foto LIKE '%P".$id_properti."2.%'");
            }
        }

        if($_FILES['foto3']['name'] != ''){
            $foto3tipe = $_FILES['foto3']['type'];
            if(!($foto3tipe == 'image/png' or $foto3tipe == 'image/jpeg' or $foto3tipe == 'image/jpg')){
                $cekFormatFoto3 = false;
            } else {
                $foto3_ext = pathinfo($_FILES['foto3']['name'], PATHINFO_EXTENSION);
                $foto3 = "P".$id_properti."3.".$foto3_ext;
                $foto_temp3 = $_FILES['foto3']['tmp_name'];
                move_uploaded_file($foto_temp3, $directory."/".$foto3);
                // Update path foto dalam database
                mysqli_query($conn, "UPDATE foto_properti SET foto='$directory/$foto3' WHERE id_properti='$id_properti' AND foto LIKE '%P".$id_properti."3.%'");
            }
        }

        if($cekFormatFoto1 == true and $cekFormatFoto2 == true and $cekFormatFoto3 == true){
            if($nama_properti == $cek_nama['nama_properti']){
                $query = mysqli_query($conn,"UPDATE informasi_properti SET jenis_properti = '$jenis_properti',deskripsi = '$deskripsi',Tipe = '$Tipe',harga = '$harga', alamat = '$alamat',furnished = '$furnished',jml_kamar = '$jml_kamar',jml_kmandi = '$jml_kmandi', daerah = '$daerah' WHERE id_properti = '$id_properti'") or die("ERROR ini"); // Tambahkan 'daerah' ke query update
            } else {
                $cek_nama = mysqli_num_rows(mysqli_query($conn,"SELECT nama_properti FROM informasi_properti WHERE id_properti != '$id_properti' AND nama_properti = '$nama_properti'"));
                if($cek_nama > 0){
                    echo "<script>
                        alert('Nama properti telah digunakan seller lain, gunakan nama yang lain!');
                        window.location.href='edit-properti.php?id_properti=".$id_properti."';
                    </script>";
                } else {
                    $query = mysqli_query($conn,"UPDATE informasi_properti SET nama_properti = '$nama_properti',jenis_properti = '$jenis_properti',deskripsi = '$deskripsi',Tipe = '$Tipe',harga = '$harga', alamat = '$alamat',furnished = '$furnished',jml_kamar = '$jml_kamar',jml_kmandi = '$jml_kmandi', daerah = '$daerah' WHERE id_properti = '$id_properti'") or die("ERROR ini"); // Tambahkan 'daerah' ke query update
                }
            }
            echo "<script>
            alert('Berhasil melakukan update informasi!');
            window.location.href='edit-properti-menu.php';
            </script>";  
        } else {
            echo "<script>
                alert('Format foto harus PNG/JPG/JPEG!');
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
    <title>Khansa - Edit-Properti</title>
</head>
<body>
<?php include 'nav.php' ?>
    <main>
        <div class="title">
            <h3>Edit Informasi Properti</h3>
        </div>
        <div class="gambar-properti">
            <?php
                while($result_foto = mysqli_fetch_array($query_foto)){
                    echo "<img src='$result_foto[0]' alt='Foto Properti'>";
                }
            ?>
        </div>
        <?php 
            $result = mysqli_fetch_array($info);
            $judul = $result['nama_properti'];
            $alamat = $result['alamat'];
            $Tipe = $result['Tipe'];
            $kamar_tidur = $result['jml_kamar'];
            $kamar_mandi = $result['jml_kmandi'];
            $deskripsi = $result['deskripsi'];
            $harga = $result['harga'];
            $daerah = $result['daerah'];
            $link_google_maps = '';  // Initialize with an empty string as default

            if (isset($_POST['link_google_maps'])) {
                $link_google_maps = $_POST['link_google_maps'];
             }

        ?>
        <p style="font-size: 20px; color: red; margin-top: 10px; text-align: center;"><?php echo $error_message; ?></p>
        <div class="insert-info">
            <form action="" method="POST" enctype="multipart/form-data">    
                <label for="judul"> Nama Properti </label>
                <input class="jinput" type="text" id="judul" name="judul" value='<?php echo $judul ?>'>  
                <label for="jenis"> Jenis Properti </label>
                <select id="jenis" name="jenis" class="jinput">
                    <option value="Rumah">Rumah</option>
                    <option value="Rumah Toko">Rumah Toko</option>
                    <option value="Rumah Susun">Rumah Susun</option>
                    <option value="Apartement">Apartement</option>
                </select>
                <label for="alamat"> Alamat </label>
                <input class="jinput" style="width: 100%;" type="text" id="alamat" name="alamat" value='<?php echo $alamat ?>'> 
                <label for="Tipe"> Tipe </label>
                <select id="Tipe" name="Tipe" class="jinput" required>
                <option value="40">40</option>
                <option value="45">45</option>
                <option value="90">90</option>
                </select>
                <label for="kamar-tidur">Jumlah Kamar Tidur</label>
                <input class="jinput" type="number" id="kamar-tidur" name="kamar-tidur" value='<?php echo $kamar_tidur ?>'>
                <label for="kamar-mandi">Jumlah Kamar Mandi</label>
                <input class="jinput" type="number" id="kamar-mandi" name="kamar-mandi" value='<?php echo $kamar_mandi ?>'>
                <label for="furnished"> Furnished</label> 
                <select id="furnished" name="furnished" class="jinput">
                    <option value="Iya">Iya</option>
                    <option value="Tidak">Tidak</option>
                </select>
                <label for="daerah"> Daerah </label>
                <select id="daerah" name="daerah" class="jinput" required>
                <option value="Cipta Karya" <?php if ($daerah == 'Cipta Karya') echo 'selected'; ?>>Cipta Karya</option>
                <option value="Purwodadi" <?php if ($daerah == 'Purwodadi') echo 'selected'; ?>>Purwodadi</option>
                <option value="Teropong" <?php if ($daerah == 'Teropong') echo 'selected'; ?>>Teropong</option>
                </select>
                <label for="deskripsi"> Deskripsi </label>
                <textarea name ="deskripsi" class="jinput deskripsi"><?php echo $deskripsi ?></textarea>  
                <label for="harga"> Harga </label>
                <input class="jinput" type="text" id="harga" name="harga" value='<?php echo $harga ?>'>
                <label for="foto1">Foto Rumah 1</label>
                <input type="file" name="foto1" id="foto1">
                <label for="foto2">Foto Rumah 2</label>
                <input type="file" name="foto2" id="foto2">
                <label for="foto3">Foto Rumah 3</label>
                <input type="file" name="foto3" id="foto3">
                <label for="link_google_maps"> Link Google Maps </label>
                <input class="jinput" type="text" id="link_google_maps" name="link_google_maps" value='<?php echo $link_google_maps ?>'>
                <input type="submit" name="submit" Value="Submit" class="tombol-submit">
            </form>
        </div>
    </main>
    <?php include 'footer.php' ?>
</body>
</html>
