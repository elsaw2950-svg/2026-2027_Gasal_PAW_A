<?php
// FORM UBAH PELANGGAN -> dikirim ke proses_pelanggan.php (aksi=edit). ID tidak bisa diubah.
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$id = trim($_GET['id'] ?? '');
$pelanggan = null;
if ($id !== '') {
    $q = mysqli_prepare($koneksi, "SELECT * FROM pelanggan WHERE id=?");
    mysqli_stmt_bind_param($q, "s", $id);
    mysqli_stmt_execute($q);
    $pelanggan = mysqli_fetch_assoc(mysqli_stmt_get_result($q));
}
if (!$pelanggan) {
    set_flash("Data pelanggan tidak ditemukan.", 'err');
    header("Location: pelanggan.php");
    exit;
}

$judul = 'Ubah Pelanggan';
require "header.php";
?>
<div class="box">
    <h2>Ubah Pelanggan</h2>
    <form class="form" method="post" action="proses_pelanggan.php">
        <input type="hidden" name="aksi" value="edit">
        <label>ID Pelanggan</label>
        <input type="text" name="id" value="<?= e($pelanggan['id']) ?>" readonly>
        <label>Nama</label>
        <input type="text" name="nama" maxlength="100" required value="<?= e(old('nama', $pelanggan['nama'])) ?>">
        <label>Jenis Kelamin</label>
        <?php $jk = old('jenis_kelamin', $pelanggan['jenis_kelamin']); ?>
        <select name="jenis_kelamin" required>
            <option value="L" <?= $jk === 'L' ? 'selected' : '' ?>>Laki-laki</option>
            <option value="P" <?= $jk === 'P' ? 'selected' : '' ?>>Perempuan</option>
        </select>
        <label>Telp</label>
        <input type="text" name="telp" maxlength="12" pattern="[0-9]*" value="<?= e(old('telp', $pelanggan['telp'])) ?>">
        <label>Alamat</label>
        <textarea name="alamat" rows="3"><?= e(old('alamat', $pelanggan['alamat'])) ?></textarea>
        <p>
            <button class="btn" type="submit">Simpan Perubahan</button>
            <a class="btn abu" href="pelanggan.php">Batal</a>
        </p>
    </form>
</div>
<?php require "footer.php"; ?>
