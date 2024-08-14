<?php 
session_start();
include 'connect.php'; // Pastikan connect.php ada dan berfungsi dengan baik

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil daerah unik
$area_query = "SELECT DISTINCT daerah FROM informasi_properti WHERE acceptable = 'Iya'";
$area_result = mysqli_query($conn, $area_query);
if (!$area_result) {
    die("Query daerah gagal: " . mysqli_error($conn));
}
$areas = [];
while ($area = mysqli_fetch_array($area_result, MYSQLI_ASSOC)) {
    $areas[] = $area['daerah'];
}

// Tangani filter berdasarkan daerah
$area_filter = isset($_GET['area']) ? $_GET['area'] : '';

$query = "SELECT * FROM informasi_properti WHERE acceptable = 'Iya'";
if ($area_filter) {
    $query .= " AND daerah = '" . mysqli_real_escape_string($conn, $area_filter) . "'";
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
    <style>
        .booked-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 300px;
            height: 230px;
            opacity: 0.5; /* Opacity set to 70% (transparan) */
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    <main class="max-w-7xl mx-auto p-4">
        <h2 class="text-3xl font-bold text-center mb-6">Silahkan Pilih Lokasi</h2>

        <!-- Tombol Daerah -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
            <!-- Tombol Daerah dengan Background Warna -->
            <a href="?area=Cipta Karya" class="inline-block rounded bg-amber-500 px-24 py-8 text-lg font-medium text-white transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring active:bg-indigo-500 w-full text-center">
                Cipta Karya
            </a>
            <a href="?area=Teropong" class="inline-block rounded bg-amber-500 px-24 py-8 text-lg font-medium text-white transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring active:bg-indigo-500 w-full text-center">
                Teropong
            </a>
            <a href="?area=Purwodadi" class="inline-block rounded bg-amber-500 px-24 py-8 text-lg font-medium text-white transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring active:bg-indigo-500 w-full text-center">
                Purwodadi
            </a>
        </div>

        <!-- Daftar Properti -->
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8 properties mt-6 <?php echo $area_filter ? '' : 'hidden'; ?>">
            <?php   
            if (mysqli_num_rows($result) > 0) {
                while ($kartu = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $id_properti = $kartu['id_properti'];
                    $harga = number_format($kartu['harga'], 0, ',', '.');

                    // Ambil semua foto properti terkait
                    $query_foto = mysqli_query($conn, "SELECT foto FROM foto_properti WHERE id_properti = '$id_properti'");
                    if (!$query_foto) {
                        die("Query foto gagal: " . mysqli_error($conn));
                    }
                    $fotos = array();
                    while ($foto = mysqli_fetch_array($query_foto)) {
                        $fotos[] = $foto['foto'];
                    }

                    // Cek status booking properti
                    $status_booking = $kartu['status_booking'];
                    $booking_icon = ($status_booking != 'Available') ? '<img src="pictures/booooked321.jpg" alt="Booked" class="booked-icon">' : '';

                    echo "<a href='detail.php?id_properti=$id_properti' class='block relative rounded-lg p-4 shadow-sm shadow-indigo-100'>";
                    
                    // Cek jika ada foto dan tampilkan yang pertama
                    if (count($fotos) > 0) {
                        echo "<img alt='' src='" . $fotos[0] . "' class='h-56 w-full rounded-md object-cover' />";
                    } else {
                        echo "<img alt='' src='pictures/default.jpg' class='h-56 w-full rounded-md object-cover' />"; // Gambar default jika tidak ada foto
                    }
                    
                    // Tampilkan ikon booking jika properti sudah dibooking
                    echo $booking_icon;

                    echo "<div class='mt-2'>
                            <dl>
                                <div>
                                    <dt class='sr-only'>Harga</dt>
                                    <dd class='text-sm text-gray-500'>Rp. $harga</dd>
                                </div>
                                <div>
                                    <dt class='sr-only'>Alamat</dt>
                                    <dd class='font-medium'>$kartu[alamat]</dd>
                                </div>
                            </dl>
                            <div class='mt-6 flex items-center gap-8 text-xs'>
                                <div class='sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2'>
                                    <svg class='size-4 text-indigo-700' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z' />
                                    </svg>
                                    <div class='mt-1.5 sm:mt-0'>
                                        <p class='text-gray-500'>Tipe</p>
                                        <p class='font-medium'>$kartu[Tipe]</p>
                                    </div>
                                </div>
                                <div class='sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2'>
                                    <svg class='size-4 text-indigo-700' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z' />
                                    </svg>
                                    <div class='mt-1.5 sm:mt-0'>
                                        <p class='text-gray-500'>Kamar Mandi</p>
                                        <p class='font-medium'>$kartu[jml_kmandi] kamar</p>
                                    </div>
                                </div>
                                <div class='sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2'>
                                    <svg class='size-4 text-indigo-700' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z' />
                                    </svg>
                                    <div class='mt-1.5 sm:mt-0'>
                                        <p class='text-gray-500'>Kamar Tidur</p>
                                        <p class='font-medium'>$kartu[jml_kamar] kamar</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>";
                }
            } else {
                echo "<div style='margin: 50px 0; font-size: 36px;'>Tidak ada properti</div>";
            }
            ?>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
