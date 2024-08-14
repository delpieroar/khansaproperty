<?php
    $directory = 'galery';

    if($_FILES['foto1']['name'] != ''){
        $foto1 = "P".$id_properti."1.png";
        $foto_temp1 = $_FILES['foto1']['tmp_name'];
        $path_foto = "galery/".$foto1;
        move_uploaded_file($foto_temp1,$directory."/".$foto1);
    }

    if($_FILES['foto2']['name'] != ''){
        $foto2 = "P".$id_properti."2.png";
        $foto_temp2 = $_FILES['foto2']['tmp_name'];
        $path_foto = "galery/".$foto2;
        move_uploaded_file($foto_temp2,$directory."/".$foto2);
    }

    if($_FILES['foto3']['name'] != ''){
        $foto3 = "P".$id_properti."3.png";
        $foto_temp3 = $_FILES['foto3']['tmp_name'];
        $path_foto = "galery/".$foto3;
        move_uploaded_file($foto_temp3,$directory."/".$foto3);
    }
    
        /*
        
        Format Foto 1

        $foto1 = "P".$id_properti."1.png";
        $foto_temp1 = $_FILES['foto1']['tmp_name'];
        $path_foto = "galery/".$foto1;
        move_uploaded_file($foto_temp1,$directory."/".$foto1);

        Format Foto 2

        $foto2 = "P".$id_properti."2.png";
        $foto_temp2 = $_FILES['foto2']['tmp_name'];
        $path_foto = "galery/".$foto2;
        move_uploaded_file($foto_temp2,$directory."/".$foto2);

        Format Foto 3

        $foto3 = "P".$id_properti."3.png";
        $foto_temp3 = $_FILES['foto3']['tmp_name'];
        $path_foto = "galery/".$foto3;
        move_uploaded_file($foto_temp3,$directory."/".$foto3);
        $error_message = "BERHASIL UPDATE DATA";

        */
?>