<?php
// FORM UBAH SUPPLIER -> dikirim ke proses_supplier.php (aksi=edit)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$supplier = null;
if ($id) {
    $q = mysqli_prepare($koneksi, "SELECT * FROM supplier WHERE id=?");
    mysqli_stmt_bind_param($q, "i", $id);
    mysqli_stmt_execute($q);
    $supplier = mysqli_fetch_assoc(mysqli_stmt_get_result($q));
}
if (!$supplier) {
    set_flash("Data supplier tidak ditemukan.", 'err');
    header("Location: supplier.php");
    exit;
}

$judul = 'Ubah Supplier';
require "header.php";
?>
<div class="box">
    <h2>Ubah Supplier</h2>
    <form class="form" method="post" action="proses_supplier.php">
        <input type="hidden" name="aksi" value="edit">
        <input type="hidden" name="id" value="<?= (int) $supplier['id'] ?>">
        <label>Nama Supplier</label>
        <input type="text" name="nama" maxlength="100" required value="<?= e(old('nama', $supplier['nama'])) ?>">
        <label>Telp</label>
        <input type="text" name="telp" maxlength="12" pattern="[0-9]*" value="<?= e(old('telp', $supplier['telp'])) ?>">
        <label>Alamat</label>
        <textarea name="alamat" rows="3"><?= e(old('alamat', $supplier['alamat'])) ?></textarea>
        <p>
            <button class="btn" type="submit">Simpan Perubahan</button>
            <a class="btn abu" href="supplier.php">Batal</a>
        </p>
    </form>
</div>
<?php require "footer.php"; ?>
