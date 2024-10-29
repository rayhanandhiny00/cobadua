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

$title = 'Data Akun';

include("layout/header.php");

//tampil seluruh data
$data_akun = select("SELECT * FROM akun");

//tampil data berdasarkan user
$id_akun = $_SESSION['id_akun'];

$data_login = select("SELECT * FROM akun WHERE id_akun = $id_akun");

//jika tombol hapus ditekan jalan script dibawah (tutor ada di crud barang)
if (isset($_POST['hapus'])) {
    $hapus = mysqli_query($db, "DELETE FROM akun WHERE id_akun='" . $_POST['id_akun'] . "'");
    if ($hapus) {
        echo "<script>
                alert('Akun Berhasil Dihapus');
                document.location.href = 'akun.php'
             </script>";
    }   else {
        echo "<script>
                alert('Akun Gagal Dihapus');
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
                <div class="col-sm-6">
                    <h1 class="m-0">Akun</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Akun</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.contente header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-lightblue card-outline">
                        <div class="card-body">
                            <table class="table table-bordered" id="table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama</th>
                                        <th>Telepon</th>
                                        <th>Posisi</th>
                                        <th width="19%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_akun as $akun) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $akun['nama_a']; ?></td>
                                        <td><?= $akun['tlp']; ?></td>
                                        <td><?= $akun['role'] == 1 ? 'Owner' : ($akun['role'] == 2 ? 'Admin' : 'Sales'); ?></td>
                                        <td class="text-center">
                                            <a href="detailakun.php?id_akun=<?= $akun['id_akun'];?>" class="btn btn-sm" style="background-color: #CADEED">Detail <i class="fas fa-info-circle"></i></a>
                                            <?php if ($_SESSION["role"] == 1 ) : ?>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalhapus<?= $akun['id_akun']; ?>">Hapus <i class="fas fa-trash-alt"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!-- /.card body -->
                    </div><!-- /.card biasa -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div> <!-- /.container fluid -->  
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Modal Hapus -->
<!-- id dibawah harus sama kayak data-bs-target yg atas (modalhapus) -->
<?php foreach ($data_akun as $akun) : ?>
<div class="modal fade" id="modalhapus<?= $akun['id_akun']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form method="POST" action="daftarcabang.php"></form>
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input type="hidden" name="id_akun" value="<?= $akun['id_akun']; ?>">
        <div class="modal-body">
            <p>Yakin <b><?= $akun['nama_a'];?></b> Ingin Dihapus dari Data ?</p>    
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="hapusakun.php?id_akun=<?= $akun['id_akun'];?>" class="btn btn-danger" name="hapus">Hapus</a href="">
            </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php 

include("layout/footer.php");

?>