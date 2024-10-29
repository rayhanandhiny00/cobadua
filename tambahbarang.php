<?php 

session_start();

include("security/bataslogin.php");

if ($_SESSION["role"] != 2 ){
    echo"<script>
        alert('Anda tidak dapat akses pada halaman ini');
        document.location.href = 'barang.php';
    </script>";
    exit;
}

$title = 'Tambah Barang';

include("layout/header.php");

//cek tombol tambah ditekan
if (isset($_POST["tambah"])) {
    if (create_barang($_POST) > 0) {
        echo "<script>
                alert('Data Barang Berhasil Ditambahkan');
                document.location.href = 'barang.php'
             </script>";
    }   else {
        echo "<script>
                alert('Data Barang Gagal Ditambahkan');
                document.location.href = 'barang.php'
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
                        <li class="breadcrumb-item"><a href="barang.php">Barang</a></li>
                        <li class="breadcrumb-item active">Tambah Barang</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="background-color: #B3BDCA">
                <h1 class="card-title">Tambah Barang</h1>
            </div>
            <form action="" method="post">
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_b" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_b" name="nama_b" placeholder="Nama barang" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga" required>
                    </div>
                </div><!-- /.card body -->
                <div class="card-footer">
                    <button type="submit" name="tambah" class="btn" style="background-color: #B3BDCA; float: right">Tambah</button>
                </div><!-- card footer -->
            </form>
        </div><!-- /.container fluid -->
    </section><!-- /.content -->
</div><!-- /.content wrapper -->

<?php 

include("layout/footer.php");

?>