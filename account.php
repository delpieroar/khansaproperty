<?php
session_start();
include 'connect.php';
$error_message = '';

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $data_user = mysqli_query($conn, "SELECT * FROM pengguna WHERE id_pengguna = '$id'");
    if (mysqli_num_rows($data_user) > 0) {
        $data_fetch = mysqli_fetch_array($data_user);
        $nama_user = $data_fetch['nama'];
        $email_user = $data_fetch['email'];
        $no_user = $data_fetch['no_hp'];
        $foto_user = $data_fetch['profile_picture'];
        $tanggal_buat = $data_fetch['tanggal_buat'];
    } else {
        session_destroy();
        header('Location: login.php');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}

if (isset($_POST['register'])) {
    if ($data_fetch['password'] == $_POST['ver_password']) {
        $new_nama_user = $_POST['nama'];
        $new_no_hp = $_POST['no_hp'];
        $query = "UPDATE pengguna SET nama = '$new_nama_user', no_hp = '$new_no_hp' WHERE id_pengguna = '$id'";
        $execution = mysqli_query($conn, $query);
        
        if (isset($_FILES['foto-profil']['name']) && $_FILES['foto-profil']['error'] == UPLOAD_ERR_OK) {
            $file_type = strtolower(pathinfo($_FILES['foto-profil']['name'], PATHINFO_EXTENSION));
            if (in_array($file_type, ['jpg', 'jpeg', 'png'])) {
                $profile_picture_name = $id . '.' . $file_type;
                $uploads_dir = 'profile';
                if (!is_dir($uploads_dir)) {
                    mkdir($uploads_dir, 0777, true);
                }
                $target_file = $uploads_dir . '/' . $profile_picture_name;
                if (move_uploaded_file($_FILES['foto-profil']['tmp_name'], $target_file)) {
                    $image_path = $target_file;
                    $query = "UPDATE pengguna SET profile_picture = '$image_path' WHERE id_pengguna = '$id'";
                    $execution = mysqli_query($conn, $query);
                } else {
                    $error_message = "Gagal mengunggah gambar.";
                }
            } else {
                $error_message = "Format file tidak didukung. Unggah file JPG, JPEG, atau PNG.";
            }
        }

        if ($execution) {
            echo "<script>
                    alert('Data berhasil diganti!');
                    window.location.href='account.php';
                  </script>";
        } else {
            $error_message = "Data gagal diperbaharui";
        }
    } else {
        $error_message = "Password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="style/account.css?v=<?php echo time(); ?>" type="text/css">
    <title>Khansa - Account</title>
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <div class="title">
            <h1>Account</h1>
        </div>
        <div class="profile-pictures">
            <img src="<?php echo $foto_user . '?' . time(); ?>"> <!-- Tambahkan timestamp untuk mencegah caching -->
        </div>
        <div class="name">
            <h3><?php echo $nama_user; ?></h3>
        </div>
        <h3>Bergabung sejak: <?php echo $tanggal_buat; ?></h3>
        <div class="information">
            <div class="sub-information">
                <img src="pictures/email.png" alt="Email" class="email">
                <h3>Email:</h3>
                <h2><?php echo $email_user; ?></h2>
            </div>
            <div class="sub-information">
                <img src="pictures/phone.png" alt="Phone" class="phone">
                <h3>Phone Number:</h3>
                <h2>+62 <?php echo $no_user; ?></h2>
            </div>     
        </div>
        <div class="tombol-manajemen">
            <a href="man_account.php" class="tombol-manajemen-akun">ACCOUNT MANAGEMENT</a>
            <a href="change_password.php" class="tombol-manajemen-akun">CHANGE PASSWORD</a>
            <a href="logout.php" class="tombol-logout">LOG OUT</a>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
