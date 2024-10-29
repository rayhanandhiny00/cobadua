<?php 
session_start();

include("security/bataslogin.php");

if ($_SESSION["role"] == 2 ){
    echo"<script>
        alert('Anda tidak dapat akses pada halaman ini');
        document.location.href = 'index.php';
    </script>";
    exit;
}

$title = 'Absensi';

include("layout/header.php");

$id_akun = $_SESSION['id_akun'];

// Query ambil data akun
$akun = select("SELECT * FROM akun WHERE id_akun = $id_akun")[0];
$role = $akun['role'];

if ($role != 3) {
    $data_absensi = select("SELECT * FROM absensi ORDER BY tanggal DESC");
} else {
    $data_absensi = select("SELECT * FROM absensi WHERE nama_a = '{$akun['nama_a']}' ORDER BY tanggal DESC");
}

if (isset($_POST["simpan"])) {
    if (absensls($_POST) > 0) {
        echo "<script>
                alert('Absensi Berhasil Disimpan');
                document.location.href = 'absen.php'
             </script>";
    } else {
        echo "<script>
                alert('Absensi Gagal Disimpan');
                document.location.href = 'absen.php'
             </script>";
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Absensi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Absensi</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <?php if ($_SESSION["role"] == 3 ) : ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-tabs card-light">
                        <div class="card-header p-0 pt-1" style="background-color: #9EAFC1">
                            <ul class="nav nav-tabs" id="tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tabs-one-detail-tab" data-toggle="pill" href="#tabs-one-detail" role="tab" aria-controls="tabs-one-detail" aria-selected="true">Absensi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tabs-one-change-tab" data-toggle="pill" href="#tabs-one-change" role="tab" aria-controls="tabs-one-change" aria-selected="false">Daftar Absensi</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="tabs-one-detail" role="tabpanel" aria-labelledby="tabs-one-detail-tab">
                                    <form class="dapatlokasi" action="" method="post" onload="getLocation();">
                                        <input type="hidden" name="nama_a" value="<?= $akun['nama_a'];?>">
                                        <div class="form-group row">
                                            <label for="namatoko" class="col-sm-4 col-form-label">Nama Toko</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="namatoko" name="namatoko" required>
                                            </div>
                                        </div>
                                        <input type="hidden" name="latitude" value="">
                                        <input type="hidden" name="longitude" value="">
                                        <div class="card-footer">
                                            <button type="submit" name="simpan" class="btn" style="float: right; background-color: #9EAFC1">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tabs-one-change" role="tabpanel" aria-labelledby="tabs-one-change-tab">
                                    <table id="table" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Toko</th>
                                                <th>Tanggal</th>
                                                <th>Lokasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($data_absensi as $absensi ): ?>
                                            <tr>
                                                <td width="1%"><?= $no++; ?></td>
                                                <td><?= $absensi['namatoko']; ?></td>
                                                <td width="15%"><?= date('d-m-y | h:i:s', strtotime($absensi['tanggal'])); ?></td>
                                                <td style = "width: 200px; height: 250px">
                                                    <iframe src="https://www.google.com/maps?q=<?= $absensi['latitude']; ?>,<?= $absensi['longitude']; ?>&hl=id&z=14&output=embed" width="100%" height="100%"></iframe>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php else : ?>
        <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-navy card-outline">
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="20%">Nama Sales</th>
                                        <th width="20%">Nama Toko</th>
                                        <th width="15%">Tanggal</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_absensi as $absensi ): ?>
                                    <tr>
                                        <td width="1%"><?= $no++; ?></td>
                                        <td><?= $absensi['nama_a']; ?></td>
                                        <td><?= $absensi['namatoko']; ?></td>
                                        <td><?= date('d-m-y | h:i:s', strtotime($absensi['tanggal'])); ?></td>
                                        <td style = "width: 200px; height: 250px">
                                            <iframe src="https://www.google.com/maps?q=<?= $absensi['latitude']; ?>,<?= $absensi['longitude']; ?>&hl=id&z=14&output=embed" width="100%" height="100%"></iframe>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
        <?php endif; ?>
</div>

<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    console.log("Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude);
    document.querySelector('.dapatlokasi input[name="latitude"]').value = position.coords.latitude;
    document.querySelector('.dapatlokasi input[name="longitude"]').value = position.coords.longitude;
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            console.error("Error: PERMISSION_DENIED");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            console.error("Error: POSITION_UNAVAILABLE");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            console.error("Error: TIMEOUT");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            console.error("Error: UNKNOWN_ERROR");
            break;
    }
}

// Call getLocation when the page loads
document.addEventListener("DOMContentLoaded", function() {
    getLocation();
});
</script>

<?php 
    include("layout/footer.php");
?>