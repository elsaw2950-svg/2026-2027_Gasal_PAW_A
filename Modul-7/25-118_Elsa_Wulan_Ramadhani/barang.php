<?php
require "koneksi.php";
$pesan=$_GET["pesan"] ?? "";
$q=mysqli_query($koneksi,"SELECT b.id,b.kode_barang,b.nama_barang,b.harga,b.stok,s.nama AS supplier
 FROM barang b JOIN supplier s ON s.id=b.supplier_id ORDER BY b.id");
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Data Barang</title></head>
<body><header><h2>Aplikasi Penjualan - Master Detail</h2></header><nav><a href="index.php">Transaksi</a><a href="barang.php">Data Barang</a></nav>
<div><h2>Data Barang</h2>
<?php if($pesan==="terpakai"): ?><div>Barang tidak dapat dihapus karena masih digunakan pada transaksi.</div><?php elseif($pesan==="hapus"): ?><div>Data barang berhasil dihapus.</div><?php endif; ?>
<table border="1"><tr><th>ID</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Stok</th><th>Supplier</th><th>Aksi</th></tr>
<?php while($r=mysqli_fetch_assoc($q)): ?><tr><td><?= (int)$r['id'] ?></td><td><?= htmlspecialchars($r['kode_barang']) ?></td>
<td><?= htmlspecialchars($r['nama_barang']) ?></td><td>Rp <?= number_format($r['harga'],0,',','.') ?></td><td><?= (int)$r['stok'] ?></td><td><?= htmlspecialchars($r['supplier']) ?></td>
<td><a href="hapus_barang.php?id=<?= (int)$r['id'] ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a></td></tr><?php endwhile; ?></table>
</div></body></html>
