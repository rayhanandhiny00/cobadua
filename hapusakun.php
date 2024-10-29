<?php

session_start();

include("security/bataslogin.php");

if ($_SESSION["role"] != 1){
    echo"<script>
        alert('Anda tidak dapat akses pada halaman ini');
        document.location.href = 'index.php';
    </script>";
    exit;
}

$title = 'Hapus Akun';

include("config/app.php");

//menerima id akun yg mau dihapus
$id_akun = (int)$_GET['id_akun'];

// $id_akun = $_GET['id_akun'];
// $akun = select("SELECT * FROM akun WHERE id_akun = $id_akun")[0];

if (delete_akun($id_akun) > 0){
    echo "<script>
        alert('Akun Berhasil Dihapus');
        document.location.href = 'akun.php';
    </script>";
} else {
    echo "<script>
        alert('Akun Gagal Dihapus');
        document.location.href = 'akun.php';
    </script>";
}

?>