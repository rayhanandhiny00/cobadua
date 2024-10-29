<?php

session_start();

include("security/bataslogin.php");

$title = 'Edit Akun';

include("layout/header.php");

$id_akun = (int)$_GET['id_akun'];

// Query ambil data akun
$akun = select("SELECT * FROM akun WHERE id_akun = $id_akun")[0];

if (isset($_POST["edit"])) {
    if (update_akun($_POST) > 0) {
        // Perbarui sesi dengan nama baru
        if ($id_akun == $_SESSION['id_akun']) {
            $_SESSION['nama_a'] = $_POST['nama_a'];
        }
        echo "<script>
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Data akun Berhasil Diubah',
          showConfirmButton: false,
          timer: 1500
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            window.location.href = 'profile.php';
          }
        });
    </script>";
    } else {
        echo "<script>
                alert('Data Akun Gagal Diedit');
                document.location.href = 'profile.php'
             </script>";
    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="profile.php">Profile</a></li>
                        <li class="breadcrumb-item active">Edit Akun</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-navy">
                        <div class="card-header">
                            <h1 class="card-title">Edit Akun</h1>
                        </div>
                        <form action="" method="post">
                            <div class="card-body">
                                <input type="hidden" name="id_akun" value="<?= $akun['id_akun'];?>">
                                <div class="mb-3">
                                    <label for="no_a" class="form-label">Nomor Pegawai</label>
                                    <input type="text" class="form-control" id="no_a" name="no_a" readonly required value="<?= $akun['no_a'];?>">
                                </div>
                                <div class="mb-3">
                                    <label for="nama_a" class="form-label">Nama akun</label>
                                    <input type="text" class="form-control" id="nama_a" name="nama_a" placeholder="Nama akun" required value="<?= $akun['nama_a'];?>">
                                </div>
                                <div class="mb-3">
                                    <label for="jk" class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jk" name="jk" readonly required value="<?= $akun['jk'];?>">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat akun</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat akun" required value="<?= $akun['alamat'];?>">
                                </div>
                                <div class="mb-3">
                                    <label for="tlp" class="form-label">Telepon akun</label>
                                    <input type="number" class="form-control" id="tlp" name="tlp" placeholder="Telepon akun" required value="<?= $akun['tlp'];?>">
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required value="<?= $akun['username'];?>">
                                </div>
                                <input type="hidden" name="password" value="<?= $akun['password'];?>">
                                <input type="hidden" name="role" value="<?= $akun['role'];?>">
                            </div>
                            <div class="card-footer">
                                <!-- <a href="profile.php" type="button" class="btn btn-secondary">Kembali</a> -->
                                <button type="submit" name="edit" class="btn-sm bg-navy" style="float: right;">Simpan</button> 
                            </div>
                        </form>
                    </div><!-- /.card -->
                </div><!-- /.col -->
            </div><!-- row -->
        </div><!-- /.container fluid -->
    </section>

<?php 
include("layout/footer.php"); 
?>
