<?php 
    session_start();
    include 'connect.php';
?>

<?php 
    if(isset($_SESSION['id'])){
        $level = $_SESSION['level'];
        $id_properti = $_GET['acc_id'];
        if($level == 'admin'){
            $query = mysqli_query($conn,"UPDATE informasi_properti SET acceptable = 'Iya' WHERE id_properti = '$id_properti'");
            header('location:penyetujuan.php');
        }else{
            header('location:index.php');
        }
    }else{
        header('location:login.php');
    }
?>