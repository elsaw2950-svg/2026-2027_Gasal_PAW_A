<?php
// DAFTAR DATA SUPPLIER (khusus Owner / level 1)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$data = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id");

$judul = 'Data Supplier';
require "header.php";
?>
<div class="box">
    <h2>Data Supplier</h2>
    <p><a class="btn" href="tambah_supplier.php">+ Tambah Supplier</a></p>
    <table class="tbl">
        <tr><th>ID</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Aksi</th></tr>
        <?php while ($r = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= (int) $r['id'] ?></td>
            <td><?= e($r['nama']) ?></td>
            <td><?= e($r['telp']) ?></td>
            <td><?= e($r['alamat']) ?></td>
            <td>
                <a class="btn kecil" href="edit_supplier.php?id=<?= (int) $r['id'] ?>">Ubah</a>
                <form class="inline" method="post" action="hapus_supplier.php" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                    <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                    <button class="btn kecil merah" type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php require "footer.php"; ?>
