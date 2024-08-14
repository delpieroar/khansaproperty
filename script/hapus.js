/*function(){
    $(".hapus-info").click(function() {
        $('.main-semua').fadeIn();
    });
    $("#cancel-hapus").click(function(){
        $('.main-semua').fadeOut();
    });
});*/

function delconfirm(delid){
    if(confirm("Apakah Anda yakin ingin menghapus informasi tersebut?")){
        window.location.href='delete.php?delete_id=' + delid + '';
    }
}

function accconfirm(accid){
    if(confirm("Apakah Anda yakin ingin menyetujui informasi tersebut?")){
        window.location.href='accept.php?acc_id=' + accid + '';
    } 
}

function blokir(id_pengguna){
    if(confirm("Apakah Anda yakin ingin memblokir akun tersebut?")){
        window.location.href="blokir.php?id_pengguna=" + id_pengguna + '';
    }
}

function aktif(id_pengguna){
    if(confirm("Apakah Anda yakin ingin mengaktifkan akun tersebut?")){
        window.location.href="aktif.php?id_pengguna=" + id_pengguna + '';
    }
}