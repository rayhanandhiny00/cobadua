<?php

session_start();

include("security/bataslogin.php");

if ($_SESSION["role"] == 3 ){
    echo"<script>
        alert('Anda tidak dapat akses pada halaman ini');
        document.location.href = 'index.php';
    </script>";
    exit;
}

$title = 'Detail Akun';

include("layout/header.php");

//ambil id akun
$id_akun = (int)$_GET['id_akun'];

//menampilkan akun
$akun = select("SELECT * FROM akun WHERE id_akun = $id_akun")[0];

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="akun.php">Akun</a></li>
                        <li class="breadcrumb-item active">Detail Akun</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="background-color: #CADEED">
                <h1 class="card-title">Detail <b><?= $akun['nama_a']; ?></b></h1>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td width="25%">Nomor Pegawai</td>
                        <td>: <?= $akun['no_a']; ?></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: <?= $akun['nama_a']; ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>: <?= $akun['jk']; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: <?= $akun['alamat']; ?></td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>: <?= $akun['tlp']; ?></td>
                    </tr>
                    <tr>
                        <td>Posisi</td>
                        <td>: <?= $akun['role'] == 1 ? 'Owner' : ($akun['role'] == 2 ? 'Admin' : 'Sales'); ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="akun.php" class="btn" style="float: right ;background-color: #CADEED">Kembali</a>
            </div>
        </div><!-- /.container fluid -->
        
    </section><!-- /.content -->
</div><!-- /.content wrapper -->

<?php 

include("layout/footer.php");

?>