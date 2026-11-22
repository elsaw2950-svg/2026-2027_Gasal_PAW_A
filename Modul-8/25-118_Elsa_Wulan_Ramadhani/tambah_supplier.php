<?php
// FORM TAMBAH SUPPLIER -> dikirim ke proses_supplier.php (aksi=tambah)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$judul = 'Tambah Supplier';
require "header.php";
?>
<div class="box">
    <h2>Tambah Supplier</h2>
    <form class="form" method="post" action="proses_supplier.php">
        <input type="hidden" name="aksi" value="tambah">
        <label>Nama Supplier</label>
        <input type="text" name="nama" maxlength="100" required value="<?= e(old('nama')) ?>">
        <label>Telp</label>
        <input type="text" name="telp" maxlength="12" pattern="[0-9]*" value="<?= e(old('telp')) ?>">
        <label>Alamat</label>
        <textarea name="alamat" rows="3"><?= e(old('alamat')) ?></textarea>
        <p>
            <button class="btn" type="submit">Simpan</button>
            <a class="btn abu" href="supplier.php">Batal</a>
        </p>
    </form>
</div>
<?php require "footer.php"; ?>
