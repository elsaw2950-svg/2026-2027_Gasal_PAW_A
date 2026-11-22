<?php
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1, 2]);

$sql = "SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, p.nama AS pelanggan
        FROM transaksi t
        JOIN pelanggan p ON p.id = t.pelanggan_id
        ORDER BY t.id";
$data = mysqli_query($koneksi, $sql);

$judul = 'Transaksi';
require "header.php";
?>
<div class="box">
    <h2>Data Master Transaksi</h2>
    <p>Pilih transaksi untuk melihat dan mengelola barang pada detail transaksi.</p>
    <table class="tbl">
        <tr><th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th><th>Aksi</th></tr>
        <?php while ($r = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= (int) $r['id'] ?></td>
            <td><?= e($r['waktu_transaksi']) ?></td>
            <td><?= e($r['pelanggan']) ?></td>
            <td><?= e($r['keterangan'] ?? '') ?></td>
            <td><?= rp($r['total']) ?></td>
            <td><a class="btn kecil" href="detail.php?id=<?= (int) $r['id'] ?>">Lihat Detail</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php require "footer.php"; ?>
