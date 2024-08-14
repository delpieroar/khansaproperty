<?php 
    session_start();
    include 'connect.php';
    if(isset($_SESSION['id'])){
        $level = $_SESSION['level'];
        echo $level;
        if($level == "reguler"){
            header('location:edit-properti-menu.php');
        }else{
            header('location:manage-info.php');
        }
    }else{
        header('location:login.php');
    }
?>