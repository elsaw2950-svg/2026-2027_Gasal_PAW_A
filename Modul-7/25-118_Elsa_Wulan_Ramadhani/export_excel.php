<?php
require_once "koneksi.php";

$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

if ($tanggal_mulai === '' || $tanggal_selesai === '' || $tanggal_mulai > $tanggal_selesai) {
    die("Rentang tanggal tidak valid.");
}

$sql = "SELECT DATE(waktu_transaksi) AS tanggal,
               SUM(total) AS total_harian
        FROM transaksi
        WHERE DATE(waktu_transaksi) BETWEEN ? AND ?
        GROUP BY DATE(waktu_transaksi)
        ORDER BY tanggal ASC";

$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "ss", $tanggal_mulai, $tanggal_selesai);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);

$nama_file = "laporan_penjualan_" . $tanggal_mulai . "_sampai_" . $tanggal_selesai . ".xls";

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=" . $nama_file);
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>";

$no = 1;
$total_keseluruhan = 0;

while ($row = mysqli_fetch_assoc($hasil)) {
    $total = (float) $row['total_harian'];
    $total_keseluruhan += $total;
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . $total . "</td>";
    echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
    echo "</tr>";
}

echo "<tr><th>Total Keseluruhan</th><th>" . $total_keseluruhan . "</th><th></th></tr>";
echo "</table>";

mysqli_stmt_close($stmt);
?>