<?php
require "koneksi.php";
$sql = "SELECT t.id,t.waktu_transaksi,t.keterangan,t.total,p.nama AS pelanggan
        FROM transaksi t JOIN pelanggan p ON p.id=t.pelanggan_id ORDER BY t.id";
$data = mysqli_query($koneksi,$sql);
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Data Transaksi</title></head>
<body><header><h2>Aplikasi Penjualan - Master Detail</h2></header>
<nav><a href="index.php">Transaksi</a><a href="barang.php">Data Barang</a></nav>
<div><h2>Data Master Transaksi</h2>
<p>Pilih transaksi untuk melihat dan mengelola barang pada detail transaksi.</p>
<table border="1"><tr><th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th><th>Aksi</th></tr>
<?php while($r=mysqli_fetch_assoc($data)): ?>
<tr><td><?= (int)$r['id'] ?></td><td><?= htmlspecialchars($r['waktu_transaksi']) ?></td>
<td><?= htmlspecialchars($r['pelanggan']) ?></td><td><?= htmlspecialchars($r['keterangan'] ?? '') ?></td>
<td>Rp <?= number_format($r['total'],0,',','.') ?></td>
<td><a href="detail.php?id=<?= (int)$r['id'] ?>">Lihat Detail</a></td></tr>
<?php endwhile; ?></table></div></body></html>
