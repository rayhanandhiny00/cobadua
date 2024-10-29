<?php

session_start();

include("security/bataslogin.php");

$title = 'Hapus Pesanan';

include("config/app.php");

// Menerima id barang yang mau dihapus dan sanitasi input
$id_keluar = isset($_GET['id_keluar']) ? (int)$_GET['id_keluar'] : 0;

if ($id_keluar > 0) {
    if (delete_pesanan($id_keluar) > 0) {
        echo "<script>
            alert('Pesanan Berhasil Dihapus');
            document.location.href = 'barangkeluar.php';
        </script>";
    } else {
        echo "<script>
            alert('Pesanan Gagal Dihapus');
            document.location.href = 'barangkeluar.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID Barang tidak valid');
        document.location.href = 'barang.php';
    </script>";
}

?>
