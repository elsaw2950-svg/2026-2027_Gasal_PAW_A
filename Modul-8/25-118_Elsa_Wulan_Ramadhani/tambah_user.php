<?php
// FORM TAMBAH USER -> dikirim ke proses_user.php (aksi=tambah)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$nama_level = [1 => 'Owner', 2 => 'Kasir', 3 => 'Staff'];

$judul = 'Tambah User';
require "header.php";
?>
<div class="box">
    <h2>Tambah User</h2>
    <form class="form" method="post" action="proses_user.php" autocomplete="off">
        <input type="hidden" name="aksi" value="tambah">
        <label>Username</label>
        <input type="text" name="username" maxlength="30" required value="<?= e(old('username')) ?>">
        <label>Password</label>
        <input type="password" name="password" maxlength="35" required>
        <label>Nama</label>
        <input type="text" name="nama" maxlength="50" required value="<?= e(old('nama')) ?>">
        <label>Alamat</label>
        <input type="text" name="alamat" maxlength="150" value="<?= e(old('alamat')) ?>">
        <label>No HP</label>
        <input type="text" name="hp" maxlength="20" pattern="[0-9]*" value="<?= e(old('hp')) ?>">
        <label>Level</label>
        <select name="level" required>
            <option value="">-- Pilih Level --</option>
            <?php foreach ($nama_level as $k => $v): ?>
            <option value="<?= $k ?>" <?= (string) old('level') === (string) $k ? 'selected' : '' ?>><?= $k ?> - <?= e($v) ?></option>
            <?php endforeach; ?>
        </select>
        <p>
            <button class="btn" type="submit">Simpan</button>
            <a class="btn abu" href="user.php">Batal</a>
        </p>
    </form>
</div>
<?php require "footer.php"; ?>
