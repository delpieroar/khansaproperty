<?php 
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="style/confirmation.css">
    <title>Khansa - Konfirmasi Booking</title>
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <div class="confirmation">
            <h1>Booking Berhasil!</h1>
            <p>Terima kasih telah melakukan booking. Kami akan menghubungi Anda segera untuk detail lebih lanjut.</p>
            <a href="index.php">Kembali ke Beranda</a>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>