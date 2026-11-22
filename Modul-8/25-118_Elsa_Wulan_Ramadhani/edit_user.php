<?php
// FORM UBAH USER -> dikirim ke proses_user.php (aksi=edit). Password kosong = tidak diubah.
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$nama_level = [1 => 'Owner', 2 => 'Kasir', 3 => 'Staff'];

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$user = null;
if ($id) {
    $q = mysqli_prepare($koneksi, "SELECT id_user,username,nama,alamat,hp,level FROM `user` WHERE id_user=?");
    mysqli_stmt_bind_param($q, "i", $id);
    mysqli_stmt_execute($q);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($q));
}
if (!$user) {
    set_flash("Data user tidak ditemukan.", 'err');
    header("Location: user.php");
    exit;
}

$judul = 'Ubah User';
require "header.php";
?>
<div class="box">
    <h2>Ubah User</h2>
    <form class="form" method="post" action="proses_user.php" autocomplete="off">
        <input type="hidden" name="aksi" value="edit">
        <input type="hidden" name="id" value="<?= (int) $user['id_user'] ?>">
        <label>Username</label>
        <input type="text" name="username" maxlength="30" required value="<?= e(old('username', $user['username'])) ?>">
        <label>Password (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" maxlength="35">
        <label>Nama</label>
        <input type="text" name="nama" maxlength="50" required value="<?= e(old('nama', $user['nama'])) ?>">
        <label>Alamat</label>
        <input type="text" name="alamat" maxlength="150" value="<?= e(old('alamat', $user['alamat'])) ?>">
        <label>No HP</label>
        <input type="text" name="hp" maxlength="20" pattern="[0-9]*" value="<?= e(old('hp', $user['hp'])) ?>">
        <label>Level</label>
        <?php $lv = (int) old('level', $user['level']); ?>
        <select name="level" required>
            <?php foreach ($nama_level as $k => $v): ?>
            <option value="<?= $k ?>" <?= $lv === $k ? 'selected' : '' ?>><?= $k ?> - <?= e($v) ?></option>
            <?php endforeach; ?>
        </select>
        <p>
            <button class="btn" type="submit">Simpan Perubahan</button>
            <a class="btn abu" href="user.php">Batal</a>
        </p>
    </form>
</div>
<?php require "footer.php"; ?>
