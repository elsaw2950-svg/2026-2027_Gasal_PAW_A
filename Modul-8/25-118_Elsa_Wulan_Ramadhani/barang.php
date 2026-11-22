<?php
// DAFTAR DATA BARANG (khusus Owner / level 1)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$data = mysqli_query($koneksi, "SELECT b.id,b.kode_barang,b.nama_barang,b.harga,b.stok,s.nama AS supplier
 FROM barang b JOIN supplier s ON s.id=b.supplier_id ORDER BY b.id");

$judul = 'Data Barang';
require "header.php";
?>
<div class="box">
    <h2>Data Barang</h2>
    <p><a class="btn" href="tambah_barang.php">+ Tambah Barang</a></p>
    <table class="tbl">
        <tr><th>ID</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Stok</th><th>Supplier</th><th>Aksi</th></tr>
        <?php while ($r = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= (int) $r['id'] ?></td>
            <td><?= e($r['kode_barang']) ?></td>
            <td><?= e($r['nama_barang']) ?></td>
            <td><?= rp($r['harga']) ?></td>
            <td><?= (int) $r['stok'] ?></td>
            <td><?= e($r['supplier']) ?></td>
            <td>
                <a class="btn kecil" href="edit_barang.php?id=<?= (int) $r['id'] ?>">Ubah</a>
                <form class="inline" method="post" action="hapus_barang.php" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                    <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                    <button class="btn kecil merah" type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php require "footer.php"; ?>
