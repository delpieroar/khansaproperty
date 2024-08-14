<?php 
    session_start();
    include 'connect.php';
    $error_message = '';
?>

<?php
    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
        $data_user = mysqli_query($conn,"SELECT * FROM pengguna WHERE id_pengguna = '$id'");
        $data_fetch = mysqli_fetch_array($data_user);
        $nama_user = $data_fetch['nama'];
        $email_user = $data_fetch['email'];
        $no_user = $data_fetch['no_hp'];
        $foto_user = $data_fetch['profile_picture'];
        $password = $data_fetch['password'];
    }else{
        header('location:login.php');
    }  
?>

<?php
    if(isset($_POST['submit'])){
        $id = $_SESSION['id'];
        $password_baru = $_POST['password_baru'];
        $password_konfirm = $_POST['password_konfirm'];
        $query = mysqli_query($conn,"SELECT password FROM pengguna WHERE id_pengguna='$id'");
        $query = mysqli_fetch_array($query);
        $password_lama = $query['password'];
        if($_POST['password_lama'] == $password_lama){
            if($password_baru == $password_konfirm){
                $query = "UPDATE pengguna SET password = '$password_baru' WHERE id_pengguna='$id'";
                $execution = mysqli_query($conn, $query);
                if($execution){
                    echo "
                        <script>
                            alert('Password berhasil diganti!');
                            window.location.href='account.php';
                        </script>
                    ";
                }else{
                    $error_message = "ERROR PADA DATABASE";
                }
            }else{
                $error_message = "PASSWORD BARU DENGAN KONFIRMASI PASSWORD BARU TIDAK COCOK";
            }
        }else{
            $error_message = "PASSWORD LAMA SALAH";
        }
    }   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php' ?>
    <link rel="stylesheet" href="style/change_password.css" type="text/css">
    <title>Khansa - Ganti Password</title>
</head>
<body>
    <?php include 'nav.php' ?>
    <main>
        <div class="title">
            <h1>Ganti Password</h1>
        </div>
        <div class="lock-pict">
            <img src="pictures/password.png" alt="Password Picture">
        </div>
        <div class="account-input">
            <form method="POST" action="">
                <label for="password_lama">Password Lama</label>
                <input id="password_lama" type="password" name="password_lama" class="input-normal" required>
                <label for="password_baru">Password Baru</label>
                <input id="password_baru" type="password" name="password_baru" class="input-normal" required>
                <label for="password_konfirm">Konfirmasi Password Baru</label>
                <input id="password_konfirm" type="password" name="password_konfirm" class="input-normal" required>
                <div class="submit-password">
                    <input type="submit" name="submit" value="Ganti Password">
                </div>
            </form>
            <h3 class="error-message"><?php echo $error_message ?></h3>
        </div>
    </main>
    <?php include 'footer.php' ?>
</body>
</html>