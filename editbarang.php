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

$title = 'Edit Barang';

include("layout/header.php");

//mengambil id dr URL
$id_barang = (int)$_GET['id_barang'];

$barang = select("SELECT * FROM barang WHERE id_barang = $id_barang")[0];

//cek tombol edit ditekan
if (isset($_POST["edit"])) {
    if (update_barang($_POST) > 0) {
        echo "<script>
                alert('Data Barang Berhasil Diedit');
                document.location.href = 'barang.php'
             </script>";
    }   else {
        echo "<script>
                alert('Data Barang Gagal Diedit');
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
                        <li class="breadcrumb-item"><a href="sales.php">Barang</a></li>
                        <li class="breadcrumb-item active">Edit Barang</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h1 class="card-title">Edit Barang</h1>
                        </div> 
                        <div class="card-body">
                            <form action="" method="post">
                                <input type="hidden" name="id_barang" value="<?= $barang['id_barang']; ?>">
                                <div class="mb-3">
                                    <label for="nama_b" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_b" name="nama_b" value="<?= $barang['nama_b'] ?>" placeholder="Nama barang" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= $barang['jumlah'] ?>" placeholder="Jumlah" required>
                                </div>
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga" value="<?= $barang['harga'] ?>" placeholder="Harga" required>
                                </div>
                         </div><!--/.card body -->
                         <div class="card-footer">
                            <button type="submit" name="edit" class="btn btn-secondary" style="float: right;">Simpan Perubahan</button>
                            </form>
                         </div><!--/.card footer -->
                     </div><!--/. card -->
                 </div><!--/.col -->
             </div><!--/.row -->
        </div><!-- /.container fluid -->
    </section><!-- /.content -->

</div>
<!-- /.content-wrapper -->
  
<?php 

include("layout/footer.php");

?>