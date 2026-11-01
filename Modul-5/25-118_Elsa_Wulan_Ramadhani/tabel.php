<?php
require_once "koneksi.php";
$allowed = [
 'pelanggan' => ['id','nama','jenis_kelamin','telp','alamat'],
 'barang' => ['id','kode_barang','nama_barang','harga','stok','supplier_id'],
 'transaksi' => ['id','waktu_transaksi','keterangan','total','pelanggan_id'],
 'transaksi_detail' => ['transaksi_id','barang_id','harga','qty'],
 'pembayaran' => ['id','waktu_bayar','total','metode','transaksi_id'],
 'user' => ['id_user','username','password','nama','alamat','hp','level']
];
$table = $_GET['t'] ?? '';
if (!isset($allowed[$table])) { header("Location: index.php"); exit; }
$columns = $allowed[$table];
$result = mysqli_query($koneksi, "SELECT * FROM `$table`");
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Data <?= htmlspecialchars($table) ?></title><link rel="stylesheet" href="style.css"></head>
<body><div class="container"><header><h1>Data <?= htmlspecialchars(ucwords(str_replace('_',' ',$table))) ?></h1></header><main>
<div class="top-actions"><a class="btn secondary" href="index.php">Kembali ke Dashboard</a></div>
<div class="table-wrap"><table><thead><tr><?php foreach($columns as $col): ?><th><?= htmlspecialchars($col) ?></th><?php endforeach; ?></tr></thead><tbody>
<?php while($row=mysqli_fetch_assoc($result)): ?><tr><?php foreach($columns as $col): ?><td><?= htmlspecialchars((string)$row[$col]) ?></td><?php endforeach; ?></tr><?php endwhile; ?>
</tbody></table></div></main></div></body></html>
