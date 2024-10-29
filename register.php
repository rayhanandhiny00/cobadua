<?php 

session_start();

include("security/bataslogin.php");

//alert('Anda tidak dapat akses pada halaman ini'); {bisa dikasih pemberitahuan ini}
if ($_SESSION["role"] != 1 ){
    echo"<script>
        alert('Anda tidak dapat akses pada halaman ini');
        document.location.href = 'index.php';
    </script>";
    exit;
}

$title = 'Register';

include("layout/header.php");

//jika tombol tambah ditekan jalan script dibawah (tutor ada di crud barang)
if (isset($_POST['tambah'])) {
    if (create_akun($_POST) > 0) {
        echo "<script>
                alert('Akun Berhasil Ditambahkan');
                document.location.href = 'akun.php'
             </script>";
    }   else {
        echo "<script>
                alert('Akun Gagal Ditambahkan');
                document.location.href = 'akun.php'
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
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Register</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card card-lightblue">
                <div class="card-header">
                    <h3 class="card-title">Tambah Akun</h3>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label for="no_a" class="form-label">No Pegawai</label>
                        <input type="text" class="form-control" id="no_a" name="no_a" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_a" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_a" name="nama_a" required>
                    </div>
                    <div class="form-group">
                        <label for="jk" class="form-label">Jenis Kelamin</label>
                        <select name="jk" id="jk"class="form-control" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tlp" class="form-label">Nomor Telepon</label>
                        <input type="number" class="form-control" id="tlp" name="tlp" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="role">Posisi</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">-- Pilih Posisi --</option>
                            <option value="1">Pemilik</option>
                            <option value="2">Admin</option>
                            <option value="3">Sales</option>
                        </select>
                    </div>
                </div><!-- /.card body -->
                <div class="card-footer">
                    <button type="submit" name="tambah" class="btn bg-lightblue" style="float: right;">Tambah</button>
                </div><!-- /.card footer -->
                </form>
            </div><!-- /.card -->
        </div>
    </section>
</div>

<?php 

include("layout/footer.php");

?>