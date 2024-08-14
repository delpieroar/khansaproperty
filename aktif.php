<?php 
    session_start();
    include 'connect.php';
?>

<?php 
    if(isset($_SESSION['id'])){
        $level = $_SESSION['level'];
        $id_pengguna = $_GET['id_pengguna'];
        if($level == 'admin'){
            $query = mysqli_query($conn,"UPDATE pengguna SET keadaan = 'aktif' WHERE id_pengguna = '$id_pengguna'");
            header('location:manage-pengguna.php');
        }else{
            header('location:index.php');
        }
    }else{
        header('location:login.php');
    }
?>