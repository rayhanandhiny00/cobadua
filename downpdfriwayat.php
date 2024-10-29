<?php

require 'config/app.php';
require 'vendor/fpdf/fpdf.php';

if (isset($_GET['selectedMonth'])) {
    $selectedMonth = $_GET['selectedMonth'];
    $year = date('Y');

    // Membuat array nama bulan dalam bahasa Indonesia
    $bulanIndo = array(
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    );

    // Persiapan query
    $stmt = $db->prepare("SELECT * FROM riwayat WHERE YEAR(tanggal) = ? AND MONTH(tanggal) = ?");
    $stmt->bind_param("ii", $year, $selectedMonth);
    $stmt->execute();
    $result = $stmt->get_result();
    $riwayatData = $result->fetch_all(MYSQLI_ASSOC);

    // Tutup statement
    $stmt->close();
}

// Membuat PDF (menggunakan FPDF)
class PDF extends FPDF
{
    public $bulan;

    function __construct($bulan)
    {
        parent::__construct();
        $this->bulan = $bulan;
    }

    function Header()
    {
        // Tambahkan logo
        $this->Image('assets/img/logoGPS.png', 10, 6, 30); // Sesuaikan jalur dan ukuran logo
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Riwayat Pesanan Bulan ' . $this->bulan, 0, 1, 'C');
        // $this->Cell(0, 10, 'Riwayat Pesanan', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, 'Diunduh Tanggal: ' . date('d-m-Y'), 0, 1, 'R');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Ambil nama bulan dalam bahasa Indonesia
$namaBulan = $bulanIndo[$selectedMonth];
$namaFile = 'Laporan Penjualan Bulan ' . $namaBulan . ' ' . $year . '.pdf';

$pdf = new PDF($namaBulan); // Melewatkan nama bulan saat instansiasi kelas PDF
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(40, 10, 'Nama Toko', 1);
$pdf->Cell(40, 10, 'Nama Barang', 1);
$pdf->Cell(20, 10, 'Jumlah', 1);
$pdf->Cell(40, 10, 'Penerima', 1);
$pdf->Cell(40, 10, 'Tanggal', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
$no = 1;
foreach ($riwayatData as $row) {
    $pdf->Cell(10, 10, $no++, 1);
    $pdf->Cell(40, 10, $row['namatoko'], 1);
    $pdf->Cell(40, 10, $row['nmbarang'], 1);
    $pdf->Cell(20, 10, $row['jml_brg'], 1);
    $pdf->Cell(40, 10, $row['nama_a'], 1);
    $pdf->Cell(40, 10, $row['tanggal'], 1);
    $pdf->Ln();
}

$pdf->Output('D', $namaFile);

// Tutup koneksi
$mysqli->close();

?>