<?php
require_once "koneksi.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $telp = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    if ($nama !== '' && $telp !== '' && $alamat !== '') {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: supplier.php?pesan=" . urlencode("Data supplier berhasil ditambahkan"));
            exit;
        }
        $error = "Data gagal disimpan.";
    } else {
        $error = "Semua kolom harus diisi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Tambah Supplier</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container"><header><h1>Tambah Data Master Supplier Baru</h1></header><main>
<?php if(isset($error)): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" class="form">
<label>Nama<input type="text" name="nama" required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>"></label>
<label>Telp<input type="text" name="telp" maxlength="12" required value="<?= htmlspecialchars($_POST['telp'] ?? '') ?>"></label>
<label>Alamat<textarea name="alamat" required><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea></label>
<div class="form-actions"><button class="btn success" type="submit">Simpan</button><a class="btn danger" href="supplier.php">Batal</a></div>
</form></main></div></body></html>
