<?php
// FORM TAMBAH PELANGGAN -> dikirim ke proses_pelanggan.php (aksi=tambah)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$judul = 'Tambah Pelanggan';
require "header.php";
?>
<div class="box">
    <h2>Tambah Pelanggan</h2>
    <form class="form" method="post" action="proses_pelanggan.php">
        <input type="hidden" name="aksi" value="tambah">
        <label>ID Pelanggan (contoh: PLG006)</label>
        <input type="text" name="id" maxlength="20" required value="<?= e(old('id')) ?>">
        <label>Nama</label>
        <input type="text" name="nama" maxlength="100" required value="<?= e(old('nama')) ?>">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" required>
            <option value="">-- Pilih --</option>
            <option value="L" <?= old('jenis_kelamin') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
            <option value="P" <?= old('jenis_kelamin') === 'P' ? 'selected' : '' ?>>Perempuan</option>
        </select>
        <label>Telp</label>
        <input type="text" name="telp" maxlength="12" pattern="[0-9]*" value="<?= e(old('telp')) ?>">
        <label>Alamat</label>
        <textarea name="alamat" rows="3"><?= e(old('alamat')) ?></textarea>
        <p>
            <button class="btn" type="submit">Simpan</button>
            <a class="btn abu" href="pelanggan.php">Batal</a>
        </p>
    </form>
</div>
<?php require "footer.php"; ?>
