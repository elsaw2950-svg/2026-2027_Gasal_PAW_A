<?php
// DAFTAR DATA USER (khusus Owner / level 1)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$nama_level = [1 => 'Owner', 2 => 'Kasir', 3 => 'Staff'];
$data = mysqli_query($koneksi, "SELECT id_user,username,nama,alamat,hp,level FROM `user` ORDER BY id_user");

$judul = 'Data User';
require "header.php";
?>
<div class="box">
    <h2>Data User</h2>
    <p><a class="btn" href="tambah_user.php">+ Tambah User</a></p>
    <table class="tbl">
        <tr><th>ID</th><th>Username</th><th>Nama</th><th>Alamat</th><th>HP</th><th>Level</th><th>Aksi</th></tr>
        <?php while ($r = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= (int) $r['id_user'] ?></td>
            <td><?= e($r['username']) ?></td>
            <td><?= e($r['nama']) ?></td>
            <td><?= e($r['alamat']) ?></td>
            <td><?= e($r['hp']) ?></td>
            <td><?= (int) $r['level'] ?> - <?= e($nama_level[(int) $r['level']] ?? '-') ?></td>
            <td>
                <a class="btn kecil" href="edit_user.php?id=<?= (int) $r['id_user'] ?>">Ubah</a>
                <?php if ((int) $r['id_user'] !== (int) $_SESSION['id_user']): // akun sendiri tidak bisa dihapus ?>
                <form class="inline" method="post" action="hapus_user.php" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                    <input type="hidden" name="id" value="<?= (int) $r['id_user'] ?>">
                    <button class="btn kecil merah" type="submit">Hapus</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php require "footer.php"; ?>
