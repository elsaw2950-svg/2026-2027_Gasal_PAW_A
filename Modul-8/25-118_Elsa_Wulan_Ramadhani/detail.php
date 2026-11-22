<?php
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1, 2]);

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) { die("ID transaksi tidak valid."); }

$stmt = mysqli_prepare($koneksi, "SELECT t.*,p.nama AS pelanggan FROM transaksi t JOIN pelanggan p ON p.id=t.pelanggan_id WHERE t.id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$transaksi = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$transaksi) { die("Transaksi tidak ditemukan."); }

$stmt = mysqli_prepare($koneksi, "SELECT td.barang_id,b.kode_barang,b.nama_barang,td.harga,td.qty,(td.harga*td.qty) AS subtotal
 FROM transaksi_detail td JOIN barang b ON b.id=td.barang_id WHERE td.transaksi_id=? ORDER BY b.nama_barang");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$detail = mysqli_stmt_get_result($stmt);

$q = mysqli_prepare($koneksi, "SELECT b.id,b.kode_barang,b.nama_barang,b.harga,b.stok FROM barang b
 WHERE NOT EXISTS (SELECT 1 FROM transaksi_detail td WHERE td.transaksi_id=? AND td.barang_id=b.id) AND b.stok>0 ORDER BY b.nama_barang");
mysqli_stmt_bind_param($q, "i", $id);
mysqli_stmt_execute($q);
$opsi = mysqli_stmt_get_result($q);

$pesan = $_GET["pesan"] ?? "";
$judul = 'Detail Transaksi';
require "header.php";
?>
<div class="box">
    <a href="transaksi.php">&larr; Kembali</a>
    <h2>Master Transaksi #<?= (int) $id ?></h2>
    <?php if ($pesan === "berhasil"): ?>
        <div class="alert ok">Detail transaksi berhasil ditambahkan dan total transaksi telah diperbarui.</div>
    <?php endif; ?>
    <table class="tbl">
        <tr><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total Transaksi</th></tr>
        <tr>
            <td><?= e($transaksi['waktu_transaksi']) ?></td>
            <td><?= e($transaksi['pelanggan']) ?></td>
            <td><?= e($transaksi['keterangan'] ?? '') ?></td>
            <td><?= rp($transaksi['total']) ?></td>
        </tr>
    </table>
</div>

<div class="box">
    <h2>Detail Barang</h2>
    <table class="tbl">
        <tr><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
        <?php while ($r = mysqli_fetch_assoc($detail)): ?>
        <tr>
            <td><?= e($r['kode_barang']) ?></td>
            <td><?= e($r['nama_barang']) ?></td>
            <td><?= rp($r['harga']) ?></td>
            <td><?= (int) $r['qty'] ?></td>
            <td><?= rp($r['subtotal']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<div class="box">
    <h2>Tambah Detail Transaksi</h2>
    <form class="form" action="tambah_detail.php" method="post">
        <input type="hidden" name="transaksi_id" value="<?= (int) $id ?>">
        <label>Barang (barang yang sudah ada di detail tidak ditampilkan)</label>
        <select name="barang_id" required>
            <option value="">-- Pilih Barang --</option>
            <?php while ($b = mysqli_fetch_assoc($opsi)): ?>
            <option value="<?= (int) $b['id'] ?>"><?= e($b['kode_barang'] . " - " . $b['nama_barang'] . " | " . rp($b['harga']) . " | Stok " . $b['stok']) ?></option>
            <?php endwhile; ?>
        </select>
        <label>Qty</label>
        <input type="number" name="qty" min="1" required>
        <p><button class="btn" type="submit">Simpan Detail</button></p>
    </form>
</div>
<?php require "footer.php"; ?>
