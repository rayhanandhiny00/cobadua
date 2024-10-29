<?php 

include 'config/app.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css"></link>

    <link rel="stylesheet" type="text/css" href="css/all.css">

    <title><?= $title; ?></title>
        <!-- Google Font: Source Sans Pro -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
            <link rel="stylesheet" href="tmplt/plugins/fontawesome-free/css/all.min.css">
        <!-- SweetAlert CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <!-- SweetAlert JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
            <link rel="stylesheet" href="tmplt/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <!-- iCheck -->
            <link rel="stylesheet" href="tmplt/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- JQVMap -->
            <link rel="stylesheet" href="tmplt/plugins/jqvmap/jqvmap.min.css">
        <!-- SweetAlert2 -->
            <link rel="stylesheet" href="tmplt/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <!-- Theme style -->
            <link rel="stylesheet" href="tmplt/dist/css/adminlte.min.css">
        <!-- overlayScrollbars -->
            <link rel="stylesheet" href="tmplt/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Daterange picker -->
            <link rel="stylesheet" href="tmplt/plugins/daterangepicker/daterangepicker.css">
        <!-- summernote -->
            <link rel="stylesheet" href="tmplt/plugins/summernote/summernote-bs4.min.css">
        <!-- DataTables -->
            <link rel="stylesheet" href="tmplt//plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
            <link rel="stylesheet" href="tmplt//plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
            <link rel="stylesheet" href="tmplt//plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <!-- Lokasi PHP Bootstrap -->
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    #map {
                    height: 400px;
                    width: 100%;
                    }
                </style>
            <link rel="icon" href="assets/img/logoGPS.png">

<style>
    .text-large {
        font-size: 18px;
        font-family: 'Arial', sans-serif;
        /* Pilih font yang sesuai dengan kebutuhan Anda */
    }
</style>
</head>

<body class="hold-transition sidebar layout-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-navy navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars fa-lg" style="color: #e7e8e7;"></i></a>
            </li>
        </ul>
    </nav><!-- /.navbar -->

<!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-navy elevation-4">
        <!-- Brand Logo -->
        <a href="index.php" class="brand-link">
            <img src="assets/img/logoGPS.png" alt="GPS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="font-weight-light" style="font-size: medium;">Globalindo Prisha Sentosa</span>
        </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="tmplt/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="profile.php" class="d-block">< $_SESSION['nama_a'];?></a>
            </div>
        </div> -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="profile.php" class="d-block text-center">
                    <span class="text-large">< $_SESSION['nama_a']; ?></span>
                </a>
            </div>
        </div> -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fas fa-user fa-lg mt-2"></i>
            </div>
            <div class="info">
                <a href="profile.php" class="d-block">  <?= $_SESSION['nama_a'];?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <?php if ($_SESSION["role"] == 1 or $_SESSION["role"] == 3) : ?>
                <li class="nav-item">
                    <a href="absen.php" class="nav-link">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>Absensi</p>
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="barang.php" class="nav-link">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>Data Barang</p>
                    </a>
                </li>
                <?php if ($_SESSION["role"] == 1 or $_SESSION["role"] == 2) : ?>
                <li class="nav-item">
                    <a href="tambahstock.php" class="nav-link">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>Tambah Stok</p>
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="barangkeluar.php" class="nav-link">
                        <i class="nav-icon fas fa-shopping-basket"></i>
                        <p>Pesanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="riwayat.php" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Riwayat Pesanan</p>
                    </a>
                </li>
                <li class="nav-header">Account</li>
                <?php if ($_SESSION["role"] == 1 or $_SESSION["role"] == 2) : ?>
                <li class="nav-item">
                    <a href="akun.php" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Akun</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($_SESSION["role"] == 1) : ?>
                <li class="nav-item">
                    <a href="register.php" class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Register</p>
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link" onclick="return confirm('Yakin Ingin Logout?')">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </aside>
