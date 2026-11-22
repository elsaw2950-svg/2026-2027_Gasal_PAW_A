<?php
// DAFTAR DATA PELANGGAN (khusus Owner / level 1)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$data = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY id");

$judul = 'Data Pelanggan';
require "header.php";
?>
<div class="box">
    <h2>Data Pelanggan</h2>
    <p><a class="btn" href="tambah_pelanggan.php">+ Tambah Pelanggan</a></p>
    <table class="tbl">
        <tr><th>ID</th><th>Nama</th><th>JK</th><th>Telp</th><th>Alamat</th><th>Aksi</th></tr>
        <?php while ($r = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= e($r['id']) ?></td>
            <td><?= e($r['nama']) ?></td>
            <td><?= e($r['jenis_kelamin']) ?></td>
            <td><?= e($r['telp']) ?></td>
            <td><?= e($r['alamat']) ?></td>
            <td>
                <a class="btn kecil" href="edit_pelanggan.php?id=<?= urlencode($r['id']) ?>">Ubah</a>
                <form class="inline" method="post" action="hapus_pelanggan.php" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                    <input type="hidden" name="id" value="<?= e($r['id']) ?>">
                    <button class="btn kecil merah" type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php require "footer.php"; ?>
