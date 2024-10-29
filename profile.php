<?php

session_start();

include("security/bataslogin.php");

$title = 'Detail Akun';

include("layout/header.php");

$id_akun = $_SESSION['id_akun'];

// Ambil id_akun dari $_GET jika tersedia
if (isset($_GET['id_akun'])) {
  $id_akun = (int)$_GET['id_akun'];
}

// Ambil data akun yang sesuai dengan id_akun
$akun = select("SELECT * FROM akun WHERE id_akun = $id_akun");

// Cek apakah data akun ada
if (!empty($akun)) {
  $akun = $akun[0]; // Ambil data pertama (harusnya hanya satu row)
} else {
  $akun = null;
}

if (isset($_POST["simpan"])) {
    if (ganti_password($_POST) > 0) {
        echo "<script>
                alert('Password Berhasil Diganti');
                document.location.href = 'profile.php'
             </script>";
    }   else {
        echo "<script>
                alert('Password Gagal Diganti');
                document.location.href = 'profile.php'
             </script>";
        }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body row text-center">
                        <?php if ($akun): ?>
                            <h1><b><?= $akun['nama_a']; ?></b></h1>
                            <div class="bg-navy py-1">
                            <h4>
                                <?php
                                    if ($akun['role'] == 1) {
                                        echo "Owner";
                                    } elseif ($akun['role'] == 2) {
                                        echo "Admin";
                                    } else {
                                        echo "Sales";
                                    }
                                ?>
                            </h4>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div><!-- /.card -->
                </div><!-- /.col -->

                <div class="col-md-8">
                    <div class="card card-navy card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tabs-one-detail-tab" data-toggle="pill" href="#tabs-one-detail" role="tab" aria-controls="tabs-one-detail" aria-selected="true">Detail</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tabs-one-change-tab" data-toggle="pill" href="#tabs-one-change" role="tab" aria-controls="tabs-one-change" aria-selected="false">Edit</a>
                                </li>
                            </ul>
                            <!-- <h3 class="card-title">Detail</h3> -->
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="tabs-one-detail" role="tabpanel" aria-labelledby="tabs-one-detail-tab">
                                    <?php if ($akun): ?>
                                        <table class="table table-bordered">
                                            <tr>
                                                <td width="25%">Nomor Pegawai</td>
                                                <td>: <?= $akun['no_a']?></td>
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
                                                <td>:
                                                    <?= $akun['tlp']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Username</td>
                                                <td>:
                                                    <?= $akun['username']; ?></td>
                                            </tr>
                                        </table>
                                    <?php endif; ?> 
                                <div class="card-footer">
                                    <a href="editakun.php?id_akun=<?= $akun['id_akun'] ?>" class="btn-sm bg-navy" style="float: right ;">Ubah</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-one-change" role="tabpanel" aria-labelledby="tabs-one-change-tab">
                                <form class="form-horizontal" method="post" action="">
                                    <div class="form-group row">
                                        <label for="pwlama" class="col-sm-4 col-form-label">Password Lama</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="pwlama" name="pwlama" placeholder="Password Lama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pwbaru" class="col-sm-4 col-form-label">Password Baru</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="pwbaru" name="pwbaru" placeholder="Password Baru">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="conpwbaru" class="col-sm-4 col-form-label">Konfirmasi Password Baru</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="conpwbaru" name="conpwbaru" placeholder="Konfirmasi Password Baru">
                                        </div>
                                    </div>
                                <div class="card-footer">
                                    <button type="submit" name="simpan" class="btn-sm bg-navy" style="float: right;">Simpan</button>
                                </div>
                                </form>
                            </div>    
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container fluid -->
    </section>       
</div><!-- /.content wrapper -->


<?php 

include("layout/footer.php");

?>