<?php
    $query = mysqli_query($conn,"INSERT INTO informasi_properti (id_pengguna,nama_properti,jenis_properti,deskripsi,luas,harga,alamat,furnished,jml_kamar,jml_kmandi) VALUES ('$id','$nama_properti','$jenis_properti','$deskripsi',$luas,$harga,'$alamat','$furnished',$jml_kamar,$jml_kmandi)");
    if(isset($_FILES['foto1']['name'])){
        $foto1 = "P".$id_properti."1.png";
        $foto_temp1 = $_FILES['foto1']['tmp_name'];
        $path_foto = "galery/".$foto1;
        move_uploaded_file($foto_temp1,$directory."/".$foto1);
    }
    if(isset($_FILES['foto2']['name'])){
        $foto1 = "P".$id_properti."2.png";
        $foto_temp1 = $_FILES['foto2']['tmp_name'];
        $path_foto = "galery/".$foto2;
        move_uploaded_file($foto_temp2,$directory."/".$foto2);
    }
    if(isset($_FILES['foto3']['name'])){
        $foto1 = "P".$id_properti."3.png";
        $foto_temp1 = $_FILES['foto3']['tmp_name'];
        $path_foto = "galery/".$foto3;
        move_uploaded_file($foto_temp3,$directory."/".$foto3);
    }
?>