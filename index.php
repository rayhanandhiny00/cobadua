<?php 

session_start();

include("security/bataslogin.php");

$title = 'Data Barang';

include("layout/header.php");

$nama_a = $_SESSION['nama_a'];
$role = $_SESSION['role'];

$start_month = date('Y-m');

$totalpesanan = totalpesanan($nama_a, $role);
$totalriwayat = totalriwayat($nama_a, $role);
$absensisales = absensisales($start_month);
$pesanansales = pesanansales($start_month);

?>
  
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="index.php">Home</a></li> -->
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php if ($_SESSION["role"] == 1 ) : ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-6 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color: #5F84A2">
                        <div class="inner">
                            <h3><?= $totalpesanan; ?></h3>
                            <p>Pesanan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="barangkeluar.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-md-6 col-6">
                    <!-- small box -->
                    <div class="small-box"  style="background-color: #B7D0E1">
                        <div class="inner">
                            <h3><?= $totalriwayat; ?></h3>
                            <p>Pesanan Selesai</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-clipboard"></i>
                        </div>
                        <a href="riwayat.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
                    <div class="card">
                        <div class="card-header" style="background-color: #CDDEE5">
                            <h3 class="card-title">Progres Sales</h3>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 1%">No</th>
                                        <th style="width: 20%">Nama Sales</th>
                                        <th class="text-center">Absensi</th>
                                        <th style="width: 30%" class="text-center">Pesanan</th>
                                        <!-- <th style="width: 20%"></th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($absensisales as $nama_sales => $absensi) : ?>
                                <?php
                                    // Menghitung panjang progres bar untuk absensi (maksimal 10)
                                    $absensi_progress = min(60, $absensi);
    
                                    // Mengambil jumlah pesanan dari variabel $pesanansales untuk sales saat ini
                                    // Pastikan sales sudah pernah tercatat dalam $pesanansales
                                    $jumlah_pesanan = isset($pesanansales[$nama_sales]) ? $pesanansales[$nama_sales] : 0;
    
                                    // Menghitung panjang progres bar untuk jumlah pesanan (maksimal 30)
                                    // Anda dapat menyesuaikan nilai maksimalnya sesuai dengan kebutuhan
                                    $jumlah_pesanan_progress = min(30, $jumlah_pesanan);
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $nama_sales; ?></td>
                                        <td class="text-center">
                                            <div class="progress">
                                                <div class="progress-bar bg-navy" role="progressbar" style="width: <?= ($absensi_progress * 1.66) ?>%" aria-valuenow="<?= $absensi_progress ?>" aria-valuemin="0" aria-valuemax="10">
                                                    <?= $absensi; ?> <!-- Tampilkan jumlah absensi di dalam progres bar -->
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="progress">
                                                <div class="progress-bar bg-lightblue" role="progressbar" style="width: <?= ($jumlah_pesanan_progress * 3.33) ?>%" aria-valuenow="<?= $jumlah_pesanan_progress ?>" aria-valuemin="0" aria-valuemax="30">
                                                    <?= $jumlah_pesanan; ?> <!-- Tampilkan jumlah pesanan di dalam progres bar -->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
    <?php elseif ($_SESSION["role"] == 2) : ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-6 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color: #5F84A2">
                        <div class="inner">
                            <h3><?= $totalpesanan; ?></h3>
                            <p>Pesanan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="barangkeluar.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-md-6 col-6">
                    <!-- small box -->
                    <div class="small-box"  style="background-color: #B7D0E1">
                        <div class="inner">
                            <h3><?= $totalriwayat; ?></h3>
                            <p>Pesanan Selesai</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-clipboard"></i>
                        </div>
                        <a href="riwayat.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php else : ?>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-6 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color: #5F84A2">
                        <div class="inner">
                            <h3><?= $totalpesanan; ?></h3>
                            <p>Pesanan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="barangkeluar.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-md-6 col-6">
                    <!-- small box -->
                    <div class="small-box"  style="background-color: #B7D0E1">
                        <div class="inner">
                            <h3><?= $totalriwayat; ?></h3>
                            <p>Pesanan Selesai</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-checkbox-outline"></i>
                        </div>
                        <a href="riwayat.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-header" style="background-color: #CDDEE5">
                    <h3 class="card-title">Absensi</h3>
                </div>
                <div class="card-body">
                <?php
                    $current_day = date('j'); // Mendapatkan hari dalam bulan saat ini
                    $mid_month_day = 5;
                
                    foreach ($absensisales as $nama_sales => $absensi) :
                ?>
                <?php
                    // Menghitung panjang progres bar untuk absensi (maksimal 10)
                    $absensi_progress = min(60, $absensi);

                    // Pemeriksaan peran pengguna
                    if ($role == 3 && $nama_sales != $_SESSION['nama_a'])
                    {
                        // Jika peran adalah 3 (sales) dan nama_sales tidak sama dengan pengguna saat ini,
                        // lanjutkan ke iterasi berikutnya
                        continue;
                    }
                ?>
                <?php if ($current_day >= $mid_month_day && $absensi < 10): ?>
                    <tr>
                        <td colspan="2">
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Absensi anda bulan ini masih kurang
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                    <div class="progress">
                        <div class="progress-bar bg-navy" role="progressbar" style="width: <?= ($absensi_progress * 1.66) ?>%" aria-valuenow="<?= $absensi_progress ?>" aria-valuemin="0" aria-valuemax="10">
                            <?= $absensi; ?> <!-- Tampilkan jumlah absensi di dalam progres bar -->
                        </div>
                    </div>
                <?php endforeach; ?>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <?php endif; ?>   
</div><!-- /.content-wrapper -->
  
<?php 

include("layout/footer.php");

?>