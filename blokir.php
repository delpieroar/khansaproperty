<?php 
    session_start();
    include 'connect.php';
?>

<?php 
    if(isset($_SESSION['id'])){
        $level = $_SESSION['level'];
        $id_pengguna = $_GET['id_pengguna'];
        if($level == 'admin'){
            $query = mysqli_query($conn, "UPDATE informasi_properti SET acceptable = 'Tidak' WHERE id_pengguna = '$id_pengguna'") or die(mysqli_error($conn));
            $query = mysqli_query($conn,"UPDATE pengguna SET keadaan = 'blokir' WHERE id_pengguna = '$id_pengguna'") or die(mysqli_error($conn));
            header('location:manage-pengguna.php');
        }else{
            header('location:index.php');
        }
    }else{
        header('location:login.php');
    }
?>