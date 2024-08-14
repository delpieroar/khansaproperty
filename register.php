<?php 
    session_start();
    include 'connect.php';
    $error_message = '';
?>

<?php
    if (isset($_SESSION['id'])) {
        header('location:index.php');
    }
?>

<?php
    if (isset($_POST['register'])) {
        $nama = filter_input(INPUT_POST, 'nama');
        $email = filter_input(INPUT_POST, 'email');
        $no_hp = filter_input(INPUT_POST, 'no_hp');
        $password = filter_input(INPUT_POST, 'password');
        $level = 'reguler';
        $profile_pictures = "pictures/profile_picture.png";
        $keadaan = 'aktif';
        if (!$conn) {
            die('Connection Failed: ');
        } else {
            $email_cek = mysqli_query($conn, "SELECT email FROM pengguna WHERE email = '$email'");
            $email_cek = mysqli_num_rows($email_cek);
            if ($email_cek > 0) {
                $error_message = "Email telah digunakan!";
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error_message = "Email tidak valid!";
                } else {
                    $query = mysqli_query($conn, "INSERT INTO pengguna (nama, email, no_hp, password, level, profile_picture, keadaan, tanggal_buat) VALUES ('$nama', '$email', '$no_hp', '$password', '$level', '$profile_pictures', '$keadaan', curdate())");
                    echo "<script>
                        alert('Berhasil melakukan proses registrasi!');
                        window.location.href='login.php';
                    </script>";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="style/login-page.css" type="text/css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Khansa - Register</title>
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-lg">
                <h1 class="text-center text-2xl font-bold text-indigo-600 sm:text-3xl">Registrasi</h1>
                <p class="mx-auto mt-4 max-w-md text-center text-gray-500">
                Selamat datang di Khansa! Daftar sekarang dan temukan kemudahan dalam mencari dan memesan properti impian Anda. 
                Dengan akun Khansa, Anda bisa mengakses fitur-fitur eksklusif yang akan memudahkan perjalanan Anda.
                </p>
                <form method="POST" action="" class="mb-0 mt-6 space-y-4 rounded-lg p-4 shadow-lg sm:p-6 lg:p-8">
                    <p class="text-center text-lg font-medium">Daftar</p>
                    <div>
                        <label for="nama" class="sr-only">Nama</label>
                        <input type="text" name="nama" id="nama" class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm" placeholder="Nama" required>
                    </div>
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" name="email" id="email" class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm" placeholder="Enter email" required>
                    </div>
                    <div>
                        <label for="no_hp" class="sr-only">Nomor Telepon (+62)</label>
                        <input type="number" name="no_hp" id="no_hp" class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm" placeholder="Nomor Telepon" required>
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="password" class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm" placeholder="Enter password" required>
                    </div>
                    <button type="submit" name="register" class="block w-full rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white">
                        Daftar!
                    </button>
                    <div class="error-message text-center text-sm text-red-500">
                        <p><?php echo $error_message ?></p>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include 'footer.php' ?>
</body>
</html>
