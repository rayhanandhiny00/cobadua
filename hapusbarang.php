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

$title = 'Hapus Barang';

include("config/app.php");

// Menerima id barang yang mau dihapus dan sanitasi input
$id_barang = isset($_GET['id_barang']) ? (int)$_GET['id_barang'] : 0;

if ($id_barang > 0) {
    if (delete_barang($id_barang) > 0) {
        echo "<script>
            alert('Data Barang Berhasil Dihapus');
            document.location.href = 'barang.php';
        </script>";
    } else {
        echo "<script>
            alert('Data Barang Gagal Dihapus');
            document.location.href = 'barang.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID Barang tidak valid');
        document.location.href = 'barang.php';
    </script>";
}

?>
