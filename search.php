<?php
    session_start();
    include 'connect.php';
?>

<?php
    if(isset($_GET['cari'])){
        $search = $_GET['cari'];
        $query = "SELECT * FROM `informasi_properti` WHERE acceptable = 'Iya' AND nama_properti LIKE '%$search%' ORDER BY id_properti DESC";
        $result = mysqli_query($conn,$query);
    }else{
        header('location:index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="style/card.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Khansa Properti</title>
</head>
<body>
    <?php include 'nav.php'; ?>
    <main>
        <div class="max-w-7xl mx-auto p-4 text-center">
            <div class="judul">
                <h3 class="text-3xl font-bold mb-6">Cari: <?php echo htmlspecialchars($search); ?></h3>
            </div>
            <?php
                if(mysqli_num_rows($result) < 1){
                    echo "<h4 class='text-red-500'>PROPERTI TIDAK DITEMUKAN!</h4>";
                } else {
                    echo "<div class='grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8'>";
                    while($kartu = mysqli_fetch_array($result)){
                        $id_properti = $kartu['id_properti'];
                        $harga = number_format($kartu['harga'] , 0, ',', '.');
                        $foto = mysqli_fetch_array(mysqli_query($conn,"SELECT foto FROM foto_properti WHERE id_properti = '$id_properti'"));

                        echo "
                        <a href='detail.php?id_properti=$id_properti' class='block rounded-lg p-4 shadow-sm shadow-indigo-100'>
                            <img class='h-56 w-full rounded-md object-cover' src='".$foto['foto']."' alt='".$kartu['nama_properti']."' />
                            <div class='mt-2'>
                                <h3 class='font-bold text-lg'>".$kartu['nama_properti']."</h3>
                                <p class='text-sm text-gray-500'>".$kartu['alamat']."</p>
                                <p class='text-sm text-gray-500'>Rp. $harga</p>
                                <div class='mt-2 flex items-center gap-2 text-xs'>
                                    <div class='flex items-center gap-1'>
                                        <img src='pictures/kamar.png' alt='Kamar' class='w-4 h-4'>
                                        <span>".$kartu['jml_kamar']."</span>
                                    </div>
                                    <div class='flex items-center gap-1'>
                                        <img src='pictures/toilet.png' alt='Toilet' class='w-4 h-4'>
                                        <span>".$kartu['jml_kmandi']."</span>
                                    </div>
                                    <div>
                                        <span>Tipe<sup></sup></span>
                                    </div>
                                </div>
                                <p class='text-sm text-gray-500'>Jenis: ".$kartu['jenis_properti']."</p>
                            </div>
                        </a>";
                    }
                    echo "</div>";
                }
            ?>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>