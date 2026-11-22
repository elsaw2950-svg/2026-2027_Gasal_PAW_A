<?php
// FORM UBAH BARANG -> dikirim ke proses_barang.php (aksi=edit)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$barang = null;
if ($id) {
    $q = mysqli_prepare($koneksi, "SELECT * FROM barang WHERE id=?");
    mysqli_stmt_bind_param($q, "i", $id);
    mysqli_stmt_execute($q);
    $barang = mysqli_fetch_assoc(mysqli_stmt_get_result($q));
}
if (!$barang) {
    set_flash("Data barang tidak ditemukan.", 'err');
    header("Location: barang.php");
    exit;
}

$suppliers = mysqli_query($koneksi, "SELECT id, nama FROM supplier ORDER BY nama");

$judul = 'Ubah Barang';
require "header.php";
?>
<div class="box">
    <h2>Ubah Barang</h2>
    <form class="form" method="post" action="proses_barang.php">
        <input type="hidden" name="aksi" value="edit">
        <input type="hidden" name="id" value="<?= (int) $barang['id'] ?>">
        <label>Kode Barang</label>
        <input type="text" name="kode_barang" maxlength="10" required value="<?= e(old('kode_barang', $barang['kode_barang'])) ?>">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" maxlength="100" required value="<?= e(old('nama_barang', $barang['nama_barang'])) ?>">
        <label>Harga</label>
        <input type="number" name="harga" min="0" required value="<?= e(old('harga', $barang['harga'])) ?>">
        <label>Stok</label>
        <input type="number" name="stok" min="0" required value="<?= e(old('stok', $barang['stok'])) ?>">
        <label>Supplier</label>
        <select name="supplier_id" required>
            <?php while ($s = mysqli_fetch_assoc($suppliers)): ?>
            <option value="<?= (int) $s['id'] ?>" <?= (int) old('supplier_id', $barang['supplier_id']) === (int) $s['id'] ? 'selected' : '' ?>><?= e($s['nama']) ?></option>
            <?php endwhile; ?>
        </select>
        <p>
            <button class="btn" type="submit">Simpan Perubahan</button>
            <a class="btn abu" href="barang.php">Batal</a>
        </p>
    </form>
</div>
<?php require "footer.php"; ?>
