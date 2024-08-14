<?php 
    session_start();
    include 'connect.php';
    $error_message = '';
?>

<?php
    if(isset($_GET['id_pengguna'])){
        if($_SESSION['level'] == 'admin'){
            $id_pengguna = $_GET['id_pengguna'];
        }else{
            header('location:login.php');
        }
    }else{
        header('location:login.php');
    }  
?>

<?php
    if(isset($_POST['submit'])){
        $password = $_POST['password_baru'];
        $query = mysqli_query($conn,"UPDATE pengguna SET password = '$password' WHERE id_pengguna = '$id_pengguna'");
        echo "<script>alert('Password pengguna berhasil diganti!')</script>";
        header('location:manage-pengguna.php');
    }   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php' ?>
    <link rel="stylesheet" href="style/change_password.css" type="text/css">
    <title>Khansa Property - Change Passsword </title>
</head>
<body>
    <?php include 'nav.php' ?>
    <main>
        <div class="title">
            <h1>Ganti Password Pengguna</h1>
        </div>
        <div class="lock-pict">
            <img src="pictures/password.png" alt="Password Picture">
        </div>
        <div class="account-input">
            <form method="POST" action="">
                <label for="password_lama">Password Baru</label>
                <input id="password_baru" type="password" name="password_baru" class="input-normal" required>
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