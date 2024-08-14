<?php
session_start();
include 'connect.php';

if(isset($_POST['id_properti']) && isset($_SESSION['id'])) {
    $id_properti = $_POST['id_properti'];
    $id_pengguna = $_SESSION['id'];

    // Update status booking properti
    $query_update = "UPDATE informasi_properti SET status_booking = 'sold out' WHERE id_properti = '$id_properti'";
    $result_update = mysqli_query($conn, $query_update);

    // Simpan informasi booking ke tabel booking
    $query_insert = "INSERT INTO booking (id_properti, id_pengguna) VALUES ('$id_properti', '$id_pengguna')";
    $result_insert = mysqli_query($conn, $query_insert);

    if($result_update && $result_insert) {
        header("Location: detail.php?id_properti=$id_properti");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
?>
