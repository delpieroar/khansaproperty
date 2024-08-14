<?php 
session_start();
include 'connect.php'; // Pastikan connect.php ada dan berfungsi dengan baik

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil tipe properti unik
$type_query = "SELECT DISTINCT Tipe FROM informasi_properti WHERE acceptable = 'Iya'";
$type_result = mysqli_query($conn, $type_query);
if (!$type_result) {
    die("Query tipe gagal: " . mysqli_error($conn));
}
$types = [];
while ($type = mysqli_fetch_array($type_result, MYSQLI_ASSOC)) {
    $types[] = $type['Tipe'];
}

// Tangani filter berdasarkan tipe
$type_filter = isset($_GET['type']) ? $_GET['type'] : '';
$query = "SELECT * FROM informasi_properti WHERE acceptable = 'Iya'";
if ($type_filter) {
    $query .= " AND Tipe = '" . mysqli_real_escape_string($conn, $type_filter) . "'";
}
$query .= " ORDER BY id_properti DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="style/card.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Property - Home</title>
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <!--Banner-->
        <div class="border-b-8 border-teal-0">
            <img src="pictures/banner123.jpg" alt="Banner" class="w-full h-auto">
        </div>
        <section class="bg-white">
            <div class="mx-auto max-w-screen-xl px-4 py-12 sm:px-6 md:py-16 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">MENGAPA MEMILIH KAMI</h2>
                    <p class="mt-4 text-gray-500 sm:text-xl">KAMI MENYEDIAKAN BERBAGAI PROPERTI UNTUK ANDA</p>
                </div>
                <div class="mt-8 sm:mt-12">
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="flex flex-col rounded-lg bg-blue-50 px-4 py-8 text-center">
                            <div class="mb-4">
                                <img src="pictures/all1234.png" alt="Beragam Properti" class="mx-auto h-16 w-16">
                            </div>
                            <dd class="text-4xl font-extrabold text-blue-600 md:text-4xl">Beragam Properti</dd>
                            <dt class="order-last text-lg font-medium text-gray-500">Menyediakan berbagai pilihan properti untuk pembeli dalam menemukan properti yang tepat</dt>
                        </div>
                        <div class="flex flex-col rounded-lg bg-blue-50 px-4 py-8 text-center">
                            <div class="mb-4">
                                <img src="pictures/rumah1234.png" alt="Jual Rumah" class="mx-auto h-16 w-16">
                            </div>
                            <dd class="text-4xl font-extrabold text-blue-600 md:text-4xl">Jual Rumah</dd>
                            <dt class="order-last text-lg font-medium text-gray-500">Anda dapat Menjual rumah anda melalui kami</dt>
                        </div>
                        <div class="flex flex-col rounded-lg bg-blue-50 px-4 py-8 text-center">
                            <div class="mb-4">
                                <img src="pictures/search.png" alt="Pencarian" class="mx-auto h-16 w-16">
                            </div>
                            <dd class="text-4xl font-extrabold text-blue-600 md:text-4xl">Pencarian</dd>
                            <dt class="order-last text-lg font-medium text-gray-500">Pembaruan sistem telah meningkatkan performa pencarian Properti, sehingga jauh lebih mudah dan cepat</dt>
                        </div>
                    </dl>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
