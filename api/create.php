<?php

//ubah halaman dari html ke json
header('Content-Type: application/json');

require '../config/app.php';

//menerima input
$nama = $_POST['nama'];
$jumlah = $_POST['jumlah'];
$harga = $_POST['harga'];

//cek validasi data
if ($nama == null) {
    echo json_encode(['pesan' => 'Nama Barang Masih Kosong']);
    exit;
}

//query tambah data barang
$query = "INSERT INTO barang VALUES (null, '$nama', '$jumlah', '$harga', current_timestamp())";
mysqli_query($db, $query);

//cek apakah data berhasil ditambah
if ($query) {
    echo json_encode(['pesan' => 'Data Barang Berhasil Ditambahkan']);
} else {
    echo json_encode(['pesan' => 'Data Barang Gagal Ditambahkan']);
}




?>