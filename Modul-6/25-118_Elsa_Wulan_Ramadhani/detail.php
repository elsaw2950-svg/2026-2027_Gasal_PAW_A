<?php
require "koneksi.php";
$id = filter_input(INPUT_GET,"id",FILTER_VALIDATE_INT);
if (!$id) { die("ID transaksi tidak valid."); }
$stmt=mysqli_prepare($koneksi,"SELECT t.*,p.nama AS pelanggan FROM transaksi t JOIN pelanggan p ON p.id=t.pelanggan_id WHERE t.id=?");
mysqli_stmt_bind_param($stmt,"i",$id); mysqli_stmt_execute($stmt);
$transaksi=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$transaksi) { die("Transaksi tidak ditemukan."); }

$stmt=mysqli_prepare($koneksi,"SELECT td.barang_id,b.kode_barang,b.nama_barang,td.harga,td.qty,(td.harga*td.qty) AS subtotal
 FROM transaksi_detail td JOIN barang b ON b.id=td.barang_id WHERE td.transaksi_id=? ORDER BY b.nama_barang");
mysqli_stmt_bind_param($stmt,"i",$id); mysqli_stmt_execute($stmt); $detail=mysqli_stmt_get_result($stmt);
$pesan=$_GET["pesan"] ?? "";
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Detail Transaksi</title></head>
<body><header><h2>Aplikasi Penjualan - Master Detail</h2></header><nav><a href="index.php">Transaksi</a><a href="barang.php">Data Barang</a></nav>
<div><a href="index.php">← Kembali</a><h2>Master Transaksi #<?= (int)$id ?></h2>
<?php if($pesan==="berhasil"): ?><div>Detail transaksi berhasil ditambahkan dan total transaksi telah diperbarui.</div><?php endif; ?>
<table border="1"><tr><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total Transaksi</th></tr>
<tr><td><?= htmlspecialchars($transaksi['waktu_transaksi']) ?></td><td><?= htmlspecialchars($transaksi['pelanggan']) ?></td>
<td><?= htmlspecialchars($transaksi['keterangan'] ?? '') ?></td><td>Rp <?= number_format($transaksi['total'],0,',','.') ?></td></tr></table>
<h2>Detail Barang</h2><table border="1"><tr><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
<?php while($r=mysqli_fetch_assoc($detail)): ?><tr><td><?= htmlspecialchars($r['kode_barang']) ?></td><td><?= htmlspecialchars($r['nama_barang']) ?></td>
<td>Rp <?= number_format($r['harga'],0,',','.') ?></td><td><?= (int)$r['qty'] ?></td><td>Rp <?= number_format($r['subtotal'],0,',','.') ?></td></tr><?php endwhile; ?>
</table>
<h2>Tambah Detail Transaksi</h2>
<form action="tambah_detail.php" method="post">
<input type="hidden" name="transaksi_id" value="<?= (int)$id ?>">
<label>Barang (barang yang sudah ada di detail tidak ditampilkan)</label>
<select name="barang_id" required><option value="">-- Pilih Barang --</option>
<?php
$q=mysqli_prepare($koneksi,"SELECT b.id,b.kode_barang,b.nama_barang,b.harga,b.stok FROM barang b
 WHERE NOT EXISTS (SELECT 1 FROM transaksi_detail td WHERE td.transaksi_id=? AND td.barang_id=b.id) AND b.stok>0 ORDER BY b.nama_barang");
mysqli_stmt_bind_param($q,"i",$id); mysqli_stmt_execute($q); $opsi=mysqli_stmt_get_result($q);
while($b=mysqli_fetch_assoc($opsi)): ?>
<option value="<?= (int)$b['id'] ?>"><?= htmlspecialchars($b['kode_barang']." - ".$b['nama_barang']." | Rp ".number_format($b['harga'],0,',','.')." | Stok ".$b['stok']) ?></option>
<?php endwhile; ?></select>
<label>Qty</label><input type="number" name="qty" min="1" required>
<button type="submit">Simpan Detail</button></form></div></body></html>
