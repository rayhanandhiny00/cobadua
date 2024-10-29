<?php 

session_start();

include("security/bataslogin.php");

$title = 'Riwayat Pesanan';

include("layout/header.php");

$id_akun = $_SESSION['id_akun'];
$akun = select("SELECT * FROM akun WHERE id_akun = $id_akun")[0];
$role = $akun['role'];

if ($role == 1 || $role == 2) {
    $daftarriwayat = select("SELECT * FROM riwayat");
} else if ($role == 3) {
    $daftarriwayat = select("SELECT * FROM riwayat WHERE nama_a = '{$akun['nama_a']}'");
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Riwayat Pesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Riwayat</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.contente header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-navy card-outline">
                        <?php if ($_SESSION["role"] != 3) : ?>
                        <div class="card-header">
                            <!-- <a href="downpdfriwayat.php" class="btn btn-primary "><i class="fas fa-file-pdf"></i></a> -->
                            <form action="downpdfriwayat.php" method="get" id="pdfForm">
                            <label for="selectedMonth">Pilih Bulan:</label>
                            <select name="selectedMonth" id="selectedMonth" required>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <button type="submit" class="btn btn-light" style="background-color: #B3BDCA">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </button>
                        </form>
                        </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <table class="table table-bordered" id="table">
                                <thead>
                                    <tr>
                                        <th width="8%">No</th>
                                        <th>Nama Toko</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <?php if ($_SESSION["role"] != 3) : ?>
                                        <th>Penerima</th>
                                        <?php endif; ?>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                <!-- menampilkan semua data jika yang login role = 1 (owner) atau 2 (admin) -->
                                <?php foreach ($daftarriwayat as $riwayat) : ?>
          
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $riwayat['namatoko']; ?></td>
                                        <td><?= $riwayat['nmbarang']; ?></td>
                                        <td><?= $riwayat['jml_brg']; ?></td>
                                        <?php if ($_SESSION["role"] != 3) : ?>
                                        <td><?= $riwayat['nama_a']; ?></td>
                                        <?php endif; ?>
                                        <td><?= $riwayat['tanggal']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <!-- < else : ?>
                                // tampil data akun sesuai yang login
                                < foreach ($data_login as $akun) : ?>
                                    <tr>
                                        <td>< $no++; ?></td>
                                        <td>< $akun['nama_a']; ?></td>
                                        <td>< $akun['tlp']; ?></td>
                                        <td>< $akun['role'] == 1 ? 'Owner' : ($akun['role'] == 2 ? 'Admin' : 'Sales'); ?></td>
                                        // <td width="10%" class="text-center">
                                            <a href="editakun.php?id_akun=< $akun['id_akun'];?>" class="btn btn-secondary btn-sm">Edit <i class="far fa-edit"></i></a>
                                        </td>
                                    </tr>
                                < endforeach; ?> -->
                              
                                </tbody>
                            </table>
                        </div><!-- /.card body -->
                    </div><!-- /.card biasa -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div> <!-- /.container fluid -->  
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php 

include("layout/footer.php");

?>