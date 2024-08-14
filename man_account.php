<?php
session_start();
include 'connect.php';
$error_message = '';

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $data_user = mysqli_query($conn, "SELECT * FROM pengguna WHERE id_pengguna = '$id'");
    $data_fetch = mysqli_fetch_array($data_user);
    $nama_user = $data_fetch['nama'];
    $email_user = $data_fetch['email'];
    $no_user = $data_fetch['no_hp'];
    $foto_user = $data_fetch['profile_picture'];
    $password = $data_fetch['password'];
} else {
    header('location:login.php');
    exit();
}

if (isset($_POST['register'])) {
    if ($password == $_POST['ver_password']) {
        $new_nama_user = $_POST['nama'];
        $new_no_hp = $_POST['no_hp'];
        $query = "UPDATE pengguna SET nama = '$new_nama_user', no_hp = '$new_no_hp' WHERE id_pengguna = '$id'";
        $execution = mysqli_query($conn, $query);
        
        // Cek apakah file diunggah
        if (isset($_FILES['foto-profil']['name']) && $_FILES['foto-profil']['error'] == UPLOAD_ERR_OK) {
            $file_type = strtolower(pathinfo($_FILES['foto-profil']['name'], PATHINFO_EXTENSION));
            if (in_array($file_type, ['jpg', 'jpeg', 'png'])) {
                $profile_picture_name = $id . '.' . $file_type;
                $uploads_dir = 'profile';
                if (!is_dir($uploads_dir)) {
                    mkdir($uploads_dir, 0777, true);
                }
                $target_file = $uploads_dir . '/' . $profile_picture_name;

                // Pindahkan file yang diunggah ke direktori target
                if (move_uploaded_file($_FILES['foto-profil']['tmp_name'], $target_file)) {
                    $image_path = $target_file;
                    $query = "UPDATE pengguna SET profile_picture = '$image_path' WHERE id_pengguna = '$id'";
                    $execution = mysqli_query($conn, $query);
                    $foto_user = $image_path; // Perbarui variabel $foto_user dengan path gambar yang baru
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
    <?php include 'header.php' ?>
    <link rel="stylesheet" href="style/man-account.css" type="text/css">
    <title>Khansa - Manajemen Akun</title>
    <style>
        .account-input {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-pictures img {
            display: block;
            margin: 0 auto 20px;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .edit-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .edit-form input[type="text"], 
        .edit-form input[type="number"], 
        .edit-form input[type="password"], 
        .edit-form input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .tombol-manajemen input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .tombol-manajemen input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'nav.php'?>
    <main>
        <div class="title">
            <h1>Manajemen Akun</h1>
        </div>
        <div class="account-input">
            <div class="profile-pictures">
                <?php 
                    if (!empty($foto_user)) {
                        echo '<img src="' . $foto_user . '" alt="Foto Profil">';
                    } else {
                        echo '<img src="default_foto.jpg" alt="Foto Profil">';
                    }
                ?>
            </div> 
            <h3>Email: <?php echo $email_user; ?></h3>
            <form action="" method="POST" enctype="multipart/form-data" class="edit-form">
                <label for="foto-profil">Foto Profil</label>
                <input id="foto-profil" name="foto-profil" type="file" accept="image/jpeg, image/png, image/jpg">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="input-normal" value="<?php echo $nama_user; ?>">
                <label for="no_hp">Nomor Telepon (+62)</label>
                <input type="number" name="no_hp" id="no_hp" class="input-normal" value="<?php echo $no_user; ?>">
                <label for="password">Konfirmasi Password</label>
                <input type="password" name="ver_password" id="password" class="input-normal" required>
                <div class="tombol-manajemen">
                    <input type="submit" value="Submit" name="register">
                </div>
            </form>
            <h3 class="error-message"><?php echo $error_message; ?></h3>
        </div>
    </main>
    <?php include 'footer.php' ?>
</body>
</html>
