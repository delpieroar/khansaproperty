<?php 
session_start();
include 'connect.php';

if (isset($_GET['id_properti'])) {
    $id_properti = $_GET['id_properti'];
    $query_info = "SELECT * FROM informasi_properti WHERE id_properti = '$id_properti'";
    $result_info = mysqli_query($conn, $query_info);

    if ($result_info) {
        $result = mysqli_fetch_array($result_info);
        $status = $result['status_booking'];
        $link_google_maps = $result['link_google_maps'];

        if ($result['acceptable'] == 'Tidak') {
            if (isset($_SESSION['id'])) {
                $id_pengguna = $_SESSION['id'];
                $level = $_SESSION['level'];
                if ($result['id_pengguna'] != $id_pengguna && $level == 'reguler') {
                    header('location:index.php');
                    exit();
                } else {
                    $id_pengguna = $result['id_pengguna'];
                }
            } else {
                header('location:index.php');
                exit();
            }
        } else {
            $id_pengguna = $result['id_pengguna'];
        }

        $query_cp = "SELECT * FROM pengguna WHERE id_pengguna = '$id_pengguna'";
        $query_foto = "SELECT foto FROM foto_properti WHERE id_properti = '$id_properti'";
        $result_cp_info = mysqli_query($conn, $query_cp);
        $result_foto_info = mysqli_query($conn, $query_foto);

        if ($result_cp_info && $result_foto_info) {
            $result_cp = mysqli_fetch_array($result_cp_info);
            $result_foto = $result_foto_info;
        } else {
            header('location:index.php');
            exit();
        }
    } else {
        header('location:index.php');
        exit();
    }
} else {
    header('location:index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="style/detail.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Khansa - Detail Properti</title>
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <div class="max-w-7xl mx-auto p-4">
            <div class="slideshow-container relative">
                <?php
                $i = 1;
                while ($tampilkan = mysqli_fetch_array($result_foto)) {
                    echo "
                    <div class='mySlides fade'>
                        <div class='numbertext'>$i / 3</div>
                        <img src='" . $tampilkan['foto'] . "' class='h-[350px] w-full object-cover sm:h-[450px]' />
                    </div>
                    ";
                    $i++;
                }
                ?>
                <a class="prev absolute top-1/2 left-0 transform -translate-y-1/2 text-2xl text-white font-bold cursor-pointer" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next absolute top-1/2 right-0 transform -translate-y-1/2 text-2xl text-white font-bold cursor-pointer" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <br>
            <div class="text-center">
                <?php for ($j = 1; $j < $i; $j++) { ?>
                    <span class="dot cursor-pointer" onclick="currentSlide(<?php echo $j; ?>)"></span>
                <?php } ?>
            </div>

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="border p-4 rounded-lg">
                    <div>
                        <h1 class="text-2xl font-bold"><?php echo $result['nama_properti']; ?></h1>
                        <h3 class="text-xl font-semibold mt-2">Rp. <?php echo number_format($result['harga'], 0, ',', '.'); ?></h3>
                        <p class="text-gray-500 mt-1"><?php echo $result['tanggal_post']; ?></p>
                    </div>
                    <div class="mt-4">
                        <p><?php echo nl2br($result['deskripsi']); ?></p>
                    </div>
                </div>
                <div class="border p-4 rounded-lg">
                    <div>
                        <h3 class="text-xl font-semibold">Informasi Lengkap</h3>
                    </div>
                    <div class="mt-4">
                        <p>Alamat: <?php echo $result['alamat']; ?></p>
                        <p>Jenis: <?php echo $result['jenis_properti']; ?></p>
                        <p>Tipe: <?php echo $result['Tipe']; ?></p>
                        <div class="flex items-center mt-2">
                            <img src="pictures/kamar.png" alt="Jumlah Kamar" class="w-6 h-6 mr-2">
                            <p><?php echo $result['jml_kamar']; ?> Kamar</p>
                        </div>
                        <div class="flex items-center mt-2">
                            <img src="pictures/toilet.png" alt="Jumlah Kamar" class="w-6 h-6 mr-2">
                            <p><?php echo $result['jml_kmandi']; ?> Kamar Mandi</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 border p-4 rounded-lg">
                <div>
                    <h3 class="text-xl font-semibold">Lokasi di Google Maps</h3>
                </div>
                <div class="mt-4 text-center">
                    <a class="inline-block rounded bg-indigo-600 px-8 py-3 text-sm font-medium text-white transition hover:rotate-2 hover:scale-110 focus:outline-none focus:ring active:bg-indigo-500" href="<?php echo $link_google_maps; ?>" target="_blank">Lokasi</a>
                </div>
            </div>

            <div class="mt-6 border p-4 rounded-lg">
                <div>
                    <h3 class="text-xl font-semibold">Contact Person</h3>
                </div>
                <div class="flex items-center mt-4">
                    <img src="<?php echo $result_cp['profile_picture']; ?>" alt="Profile Picture" class="w-16 h-16 rounded-full mr-4">
                    <div>
                        <h2 class="text-lg font-semibold"><?php echo $result_cp['nama']; ?></h2>
                        <p class="text-gray-500">Email: <a href="mailto:<?php echo $result_cp['email']; ?>" class="text-indigo-600"><?php echo $result_cp['email']; ?></a></p>
                        <p class="text-gray-500">Nomor Telepon: <a href="https://wa.me/62<?php echo $result_cp['no_hp']; ?>" class="text-indigo-600">+62 <?php echo $result_cp['no_hp']; ?></a></p>
                    </div>
                </div>
            </div>

            <?php if ($status == 'sold out') { ?>
                <div class="mt-6 border p-4 rounded-lg">
                    <div>
                        <h3 class="text-xl font-semibold">Booking</h3>
                    </div>
                    <p class="mt-2">Properti ini sudah di Booking</p>
                    <?php if (isset($_SESSION['id']) && ($result['id_pengguna'] == $_SESSION['id'] || $_SESSION['level'] == 'admin')) { ?>
                        <div class="mt-4 text-center">
                            <form action="cancel_booking.php" method="post">
                                <input type="hidden" name="id_properti" value="<?php echo $id_properti; ?>">
                                <button type="submit" class="inline-block rounded border border-current px-8 py-3 text-sm font-medium text-indigo-600 transition hover:-rotate-2 hover:scale-110 focus:outline-none focus:ring active:text-indigo-500">Batal Booking</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="mt-6 border p-4 rounded-lg">
                    <div>
                        <h3 class="text-xl font-semibold">Booking Properti Ini</h3>
                    </div>
                    <div class="mt-4 text-center">
                        <?php if (isset($_SESSION['id'])) { ?>
                            <form action="book_property.php" method="post">
                                <input type="hidden" name="id_properti" value="<?php echo $id_properti; ?>">
                                <button type="submit" class="inline-block rounded bg-indigo-600 px-8 py-3 text-sm font-medium text-white transition hover:rotate-2 hover:scale-110 focus:outline-none focus:ring active:bg-indigo-500">Booking</button>
                            </form>
                        <?php } else { ?>
                            <a href="login.php" class="inline-block rounded bg-indigo-600 px-8 py-3 text-sm font-medium text-white transition hover:rotate-2 hover:scale-110 focus:outline-none focus:ring active:bg-indigo-500">Booking</a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
    <?php include 'footer.php'; ?>
    <script src="script/detail.js"></script>
</body>
</html>
