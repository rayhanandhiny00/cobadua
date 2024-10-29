<?php 

session_start();

include("security/bataslogin.php");

$title = 'Data Barang';

include("layout/header.php");

$data_barang = select("SELECT * FROM barang ORDER BY nama_b");

?>        

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-navy card-outline">
                        <?php if ($_SESSION["role"] == 2) : ?>
                        <div class="card-header">
                            <a href="tambahbarang.php" class="btn" style="background-color: #B3BDCA">Barang <i class="fas fa-plus-circle"></i></a>
                        </div>
                        <?php endif ?>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <?php if ($_SESSION["role"] == 1 || $_SESSION["role"] == 2) : ?>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <?php endif ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_barang as $barang) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $barang['nama_b']; ?></td>
                                        <td><?= $barang['jumlah']; ?></td>
                                        <td><?= number_format($barang['harga'], 0, ',', '.'); ?></td>
                                        <?php if ($_SESSION["role"] == 1 || $_SESSION["role"] == 2) : ?>
                                        <td><?= date('d-m-y | h:i:s', strtotime($barang['tanggal'])); ?></td>
                                        <td class="text-center">
                                            <?php if ($_SESSION["role"] == 2) : ?>
                                            <a href="editbarang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-secondary btn-sm">Edit <i class="far fa-edit"></i></a>
                                            <?php elseif ($_SESSION["role"] == 1) : ?>
                                            <a href="hapusbarang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Barang Dihapus?')">Hapus <i class="fas fa-trash-alt"></i></a>
                                            <?php endif ?>
                                        </td>
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <h7><?php date_default_timezone_set('Asia/Jakarta'); echo date("d/m/Y | H:i:s"); ?></h7>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </section>
</div>

<?php 

include("layout/footer.php");

?>
