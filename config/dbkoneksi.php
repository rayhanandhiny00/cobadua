<?php   

    $db = mysqli_connect('localhost', 'root', '', 'cobadua');

    $db->query("SET time_zone = '+07:00'");

    // cek koneksi
    // if(!$db){
    //    echo 'gagal';
    // } else {
    //   echo 'berhasil';
    // }
