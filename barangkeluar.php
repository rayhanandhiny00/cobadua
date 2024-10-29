<?php 

session_start();

include("security/bataslogin.php");

$title = 'Barang Keluar';

include("layout/header.php");

$data_barang = select("SELECT * FROM barang ORDER BY nama_b");

$id_akun = $_SESSION['id_akun'];

$akun = select("SELECT * FROM akun WHERE id_akun = $id_akun")[0];

$role = $akun['role'];

if ($role == 1 || $role == 2) {
    $data_keluar = select("SELECT * FROM barang_keluar");
} else if ($role == 3) {
    $data_keluar = select("SELECT * FROM barang_keluar WHERE nama_a = '{$akun['nama_a']}'");
}

if (isset($_POST["tambah"])) {
    $result = create_pesanan($_POST);
    if ($result === 1) {
        echo "<script>
                alert('Pesanan Berhasil Ditambahkan');
                document.location.href = 'barangkeluar.php'
             </script>";
    } else if ($result === -1) {
        echo "<script>
                alert('Jumlah yang dimasukkan melebihi stok');
                document.location.href = 'barangkeluar.php'
             </script>";
    } else {
        echo "<script>
                alert('Pesanan Gagal Ditambahkan');
                document.location.href = 'barangkeluar.php'
             </script>";
    }
}

// if (isset($_POST["edit"])) {
//     $result = edit_pesanan($_POST);
//     if ($result === 1){
//         echo "<script>
//                 alert('Pesanan Berhasil Diedit');
//                 document.location.href = 'barangkeluar.php';
//             </script>";
//     } else if ($result === -11) {
//         echo "<script>
//                 alert('Jumlah yang dimasukkan melebili stok');
//                 document.location.href = 'barangkeluar.php';
//             </script>";
//     } else if ($result === 0) {
//         echo "<script>
//                 alert('Tidak ada perubahan data');
//                 document.location.href = 'barangkeluar.php';
//             </script>";
//     } else {
//         // Menampilkan pesan kesalahan yang dikembalikan oleh fungsi edit_pesanan
//         echo "<script>
//                 alert('Pesanan Gagal Diedit: $result');
//                 document.location.href = 'barangkeluar.php';
//             </script>";
//     }
// }

if (isset($_POST["edit"])) {
    $result = edit_pesanan($_POST);
    if ($result === 1){
        echo "<script>
                alert('Pesanan Berhasil Diedit');
                document.location.href = 'barangkeluar.php';
            </script>";
    } else if ($result === -11) {
        echo "<script>
                alert('Jumlah yang dimasukkan melebihi stok');
                document.location.href = 'barangkeluar.php';
            </script>";
    } else if ($result === 0) {
        echo "<script>
                alert('Tidak ada perubahan data');
                document.location.href = 'barangkeluar.php';
            </script>";
    } else {
        // Menampilkan pesan kesalahan yang dikembalikan oleh fungsi edit_pesanan
        echo "<script>
                alert('Pesanan Gagal Diedit: $result');
                document.location.href = 'barangkeluar.php';
            </script>";
    }
}

if (isset($_POST["selesai"])) {
    $id_keluar = $_POST["selesai"];
    if (pesanan_selesai($id_keluar) > 0){
        echo "<script>
                alert('Pesanan Berhasil Diselesaikan');
                document.location.href = 'riwayat.php'
            </script>";
    } else {
        echo "<script>
                alert('Pesanan Gagal Diselesaikan');
                document.location.href = 'barangkeluar.php'
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
                    <h1 class="m-0">Pesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Pesanan</li>
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
                        <div class="card-header">
                            <button class="btn" style="background-color: #B3BDCA" data-toggle="modal" data-target="#tambahBarangKeluar">Tambah <i class="fas fa-plus-circle"></i></button>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Toko</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Keluar</th>
                                        <?php if ($_SESSION["role"] != 3) : ?>
                                        <th>Penerima</th>
                                        <?php endif; ?>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $no = 1;
                                foreach ($data_keluar as $barang_keluar) : 
                                    // Get the name of the item
                                    $barang_nama = '';
                                    foreach ($data_barang as $barang) {
                                        if ($barang['id_barang'] == $barang_keluar['id_barang']) {
                                            $barang_nama = $barang['nama_b'];
                                            break;
                                        }
                                    }
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $barang_keluar['namatoko']; ?></td>
                                        <td><?= $barang_nama; ?></td>
                                        <td><?= $barang_keluar['jml_brg']; ?></td>
                                        <?php if ($_SESSION["role"] != 3) : ?>
                                        <td><?= $barang_keluar['nama_a'];?></td>
                                        <?php endif; ?>
                                        <td><?= date('d-m-y | h:i:s', strtotime($barang_keluar['tanggal'])); ?></td>
                                        <td width="17%" class="text-center">
                                            <button type="button" class="btn btn-sm" style="background-color: #CADEED" data-bs-toggle="modal" data-bs-target="#editpesanan<?= $barang_keluar['id_keluar']; ?>">Edit <i class="far fa-edit"></i></button>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalselesai<?= $barang_keluar['id_keluar']; ?>">Selesai <i class="fas fa-check"></i></button>
                                            <?php if ($_SESSION["role"] == 1) : ?>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalhapus<?= $barang_keluar['id_keluar']; ?>">Hapus <i class="fas fa-trash-alt"></i></button>
                                            <?php endif ?>
                                        </td>
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

<!-- Modal Tambah Pesanan -->
<div class="modal fade" id="tambahBarangKeluar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #B3BDCA">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <div class="form-group">
                        <label for="namatoko">Nama Toko</label>
                        <input type="text" name="namatoko" id="namatoko" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="id_barang">Nama Barang</label>
                        <select name="id_barang" class="form-control" id="id_barang" required>
                            <?php foreach ($data_barang as $barang) : ?>
                                <option value="<?= $barang['id_barang']; ?>"><?= $barang['nama_b']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jml_brg">Jumlah Keluar</label>
                        <input type="number" name="jml_brg" id="jml_brg" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_a">Pengguna</label>
                        <input type="text" class="form-control" name="nama_a" id="nama_a" value="<?= $akun['nama_a']; ?>" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn" style="background-color: #B3BDCA">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pesanan -->
<?php foreach ($data_keluar as $barang_keluar) : 
    // Get the name of the item for each modal
    $barang_nama = '';
    foreach ($data_barang as $barang) {
        if ($barang['id_barang'] == $barang_keluar['id_barang']) {
            $barang_nama = $barang['nama_b'];
            break;
        }
    }
?>
<div class="modal fade" id="editpesanan<?= $barang_keluar['id_keluar']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #CADEED">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="id_keluar" value="<?= $barang_keluar['id_keluar'];?>">
                    <div class="mb-3">
                        <label for="edit_namatoko">Nama Toko</label>
                        <input type="text" name="edit_namatoko" id="edit_namatoko" class="form-control" value="<?= $barang_keluar['namatoko'];?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_id_barang">Nama Barang</label>
                        <select name="edit_id_barang" class="form-control" id="edit_id_barang" required>
                            <?php foreach ($data_barang as $barang) : ?>
                                <option value="<?= $barang['id_barang']; ?>" <?= ($barang_keluar['id_barang'] == $barang['id_barang']) ? 'selected' : null ?>>
                                    <?= $barang['nama_b']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_jml_brg">Jumlah Keluar</label>
                        <input type="number" name="edit_jml_brg" id="edit_jml_brg" class="form-control" value="<?= $barang_keluar['jml_brg'];?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_a">Pengguna</label>
                        <input type="text" class="form-control" name="edit_nama_a" id="edit_nama_a" value="<?= $barang_keluar['nama_a']; ?>" readonly>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="edit" class="btn" style="background-color: #CADEED">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal Pesanan Selesai -->
<?php foreach ($data_keluar as $barang_keluar) : ?>
<div class="modal fade" id="modalselesai<?= $barang_keluar['id_keluar']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exampleModalLabel">Menyelesaikan Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
            <p>Yakin pesanan Toko <b><?= $barang_keluar['namatoko'];?></b> telah selesai ?</p>    
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="barangkeluar.php">
                    <input type="hidden" name="selesai" value="<?= $barang_keluar['id_keluar']; ?>">
                    <button type="submit" class="btn btn-success">Selesai</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php if ($_SESSION["role"] == 1) : ?>
<!-- Modal Hapus Pesanan -->
<?php foreach ($data_keluar as $barang_keluar) : ?>
<div class="modal fade" id="modalhapus<?= $barang_keluar['id_keluar']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form method="POST" action="daftarcabang.php"></form>
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input type="hidden" name="id_akun" value="<?= $barang_keluar['id_keluar']; ?>">
        <div class="modal-body">
            <p>Yakin pesanan Toko <b><?= $barang_keluar['namatoko'];?></b> ingin dihapus ?</p>    
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="hapuspesanan.php?id_keluar=<?= $barang_keluar['id_keluar'];?>" class="btn btn-danger" name="hapus">Hapus</a href="">
            </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif ?>

<?php 

include("layout/footer.php");

?>
