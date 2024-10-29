<?php 

session_start();

include("security/bataslogin.php");

if ($_SESSION["role"] == 3){
    echo"<script>
        alert('Anda tidak dapat akses pada halaman ini');
        document.location.href = 'index.php';
    </script>";
    exit;
}

$title = 'Data Barang Masuk';

include("layout/header.php");

$data_barang = select("SELECT * FROM barang ORDER BY nama_b");
// $akun = select("SELECT * FROM akun WHERE id_akun = $id_akun");

$id_akun = $_SESSION['id_akun'];

// Ambil id_akun dari $_GET jika tersedia
// if (isset($_GET['id_akun'])) {
//   $id_akun = (int)$_GET['id_akun'];
// }

// Ambil data akun yang sesuai dengan id_akun
$akun = select("SELECT * FROM akun WHERE id_akun = $id_akun")[0];

if (isset($_POST["simpan"])) {
    if (tambah_stok($_POST) > 0) {
        echo "<script>
                alert('Barang Masuk Berhasil Ditambahkan');
                document.location.href = 'tambahstock.php'
             </script>";
    }   else {
        echo "<script>
                alert('Barang Masuk Gagal Ditambahkan');
                document.location.href = 'tambahstock.php'
             </script>";
        }
}

?>        

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Stok</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Stok</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.content header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-navy card-outline">
                        <?php if ($_SESSION["role"] == 2) : ?>
                        <div class="card-header">
                            <button class="btn" style="background-color: #B3BDCA" data-toggle="modal" data-target="#modalTambahBarangMasuk">Tambah <i class="fas fa-plus-circle"></i></button>
                        </div>
                        <?php endif ?>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Masuk</th>
                                        <th>Pengguna</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $data_barang_masuk = select("SELECT ts.*, b.nama_b as nama_barang FROM tambah_stok ts 
                                                             JOIN barang b ON ts.id_barang = b.id_barang");
                                $no = 1; 
                                ?>
                                <?php foreach ($data_barang_masuk as $barang_masuk) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $barang_masuk['nama_barang']; ?></td>
                                        <td><?= $barang_masuk['jumlah_tambah']; ?></td>
                                        <td><?= $barang_masuk['nama_a']; ?></td>
                                        <td><?= date('d-m-y | h:i:s', strtotime($barang_masuk['tanggal'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!-- /.card body -->
                        <div class="card-footer">
                            <h7><?php date_default_timezone_set('Asia/Jakarta'); echo date("d/m/Y | H:i:s"); ?></h7>
                        </div><!-- /.card footer -->
                    </div><!-- /.card biasa -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div> <!-- /.container fluid -->  
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Modal Tambah Barang Masuk -->
<div class="modal fade" id="modalTambahBarangMasuk" tabindex="-1" role="dialog" aria-labelledby="modalTambahBarangMasukLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header" style="background-color: #B3BDCA">
                    <h5 class="modal-title" id="modalTambahBarangMasukLabel">Tambah Stok Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_barang">Nama Barang</label>
                        <select class="form-control" name="id_barang" id="id_barang" required>
                            <?php foreach ($data_barang as $barang) : ?>
                                <option value="<?= $barang['id_barang']; ?>"><?= $barang['nama_b']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Masuk</label>
                        <input type="number" class="form-control" name="jumlah" id="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_a">Pengguna</label>
                        <input type="text" class="form-control" name="nama_a" id="nama_a" value="<?= $akun['nama_a']; ?>" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" class="btn" style="background-color: #B3BDCA">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 

include("layout/footer.php");

?>
