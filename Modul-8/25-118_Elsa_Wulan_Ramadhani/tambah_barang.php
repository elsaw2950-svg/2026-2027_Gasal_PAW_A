<?php
// FORM TAMBAH BARANG -> dikirim ke proses_barang.php (aksi=tambah)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$suppliers = mysqli_query($koneksi, "SELECT id, nama FROM supplier ORDER BY nama");

$judul = 'Tambah Barang';
require "header.php";
?>
<div class="box">
    <h2>Tambah Barang</h2>
    <form class="form" method="post" action="proses_barang.php">
        <input type="hidden" name="aksi" value="tambah">
        <label>Kode Barang</label>
        <input type="text" name="kode_barang" maxlength="10" required value="<?= e(old('kode_barang')) ?>">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" maxlength="100" required value="<?= e(old('nama_barang')) ?>">
        <label>Harga</label>
        <input type="number" name="harga" min="0" required value="<?= e(old('harga')) ?>">
        <label>Stok</label>
        <input type="number" name="stok" min="0" required value="<?= e(old('stok')) ?>">
        <label>Supplier</label>
        <select name="supplier_id" required>
            <option value="">-- Pilih Supplier --</option>
            <?php while ($s = mysqli_fetch_assoc($suppliers)): ?>
            <option value="<?= (int) $s['id'] ?>" <?= (string) old('supplier_id') === (string) $s['id'] ? 'selected' : '' ?>><?= e($s['nama']) ?></option>
            <?php endwhile; ?>
        </select>
        <p>
            <button class="btn" type="submit">Simpan</button>
            <a class="btn abu" href="barang.php">Batal</a>
        </p>
    </form>
</div>
<?php require "footer.php"; ?>
