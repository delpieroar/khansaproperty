<?php
session_start();
include 'connect.php';

if(isset($_POST['id_properti']) && isset($_SESSION['id'])) {
    $id_properti = $_POST['id_properti'];
    $id_pengguna = $_SESSION['id'];

    // Pastikan yang membatalkan booking adalah admin atau pengguna yang membooking properti
    $query_check = "SELECT * FROM informasi_properti WHERE id_properti = '$id_properti' AND (id_pengguna = '$id_pengguna' OR '$id_pengguna' IN (SELECT id_pengguna FROM pengguna WHERE level = 'admin'))";
    $result_check = mysqli_query($conn, $query_check);

    if(mysqli_num_rows($result_check) > 0) {
        // Update status booking properti
        $query_update = "UPDATE informasi_properti SET status_booking = 'Available' WHERE id_properti = '$id_properti'";
        $result_update = mysqli_query($conn, $query_update);

        // Hapus informasi booking dari tabel booking
        $query_delete = "DELETE FROM booking WHERE id_properti = '$id_properti'";
        $result_delete = mysqli_query($conn, $query_delete);

        if($result_update && $result_delete) {
            header("Location: detail.php?id_properti=$id_properti");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
