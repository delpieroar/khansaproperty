<?php 
    session_start();
    include 'connect.php';
?>

<?php 
    if(isset($_SESSION['id'])){
        $level = $_SESSION['level'];
        $id_properti = $_GET['delete_id'];
        if($level == 'reguler'){
            $query = mysqli_query($conn,"SELECT id_pengguna FROM informasi_properti WHERE id_properti = '$id_properti'");
            $check = mysqli_fetch_array($query);
            if($check[0] == $_SESSION['id']){
                $query = mysqli_query($conn, "DELETE from foto_properti WHERE id_properti = $id_properti") or die(mysqli_error($conn));
                $query = mysqli_query($conn, "DELETE from informasi_properti WHERE id_properti = $id_properti") or die(mysqli_error($conn));
                header('location:hapus-properti.php');
            }else{
                header('location:management.php');
            }
        }else{
            $query = mysqli_query($conn, "DELETE from foto_properti WHERE id_properti = '$id_properti'") or die(mysqli_error($conn));
            $query = mysqli_query($conn, "DELETE from informasi_properti WHERE id_properti = '$id_properti'") or die(mysqli_error($conn));
            header('location:manage-info.php');
        }
    }else{
        header('location:login.php');
    }
?>