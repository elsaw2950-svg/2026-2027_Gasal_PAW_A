<?php
require_once "koneksi.php";
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { header("Location: supplier.php"); exit; }

$stmt = mysqli_prepare($koneksi, "SELECT * FROM supplier WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$data) { header("Location: supplier.php?pesan=" . urlencode("Data supplier tidak ditemukan")); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $telp = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    if ($nama !== '' && $telp !== '' && $alamat !== '') {
        $update = mysqli_prepare($koneksi, "UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?");
        mysqli_stmt_bind_param($update, "sssi", $nama, $telp, $alamat, $id);
        if (mysqli_stmt_execute($update)) {
            header("Location: supplier.php?pesan=" . urlencode("Data supplier berhasil diperbarui"));
            exit;
        }
        $error = "Data gagal diperbarui.";
    } else { $error = "Semua kolom harus diisi."; }
}
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit Supplier</title><link rel="stylesheet" href="style.css"></head>
<body><div class="container"><header><h1>Edit Data Master Supplier</h1></header><main>
<?php if(isset($error)): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" class="form">
<label>Nama<input type="text" name="nama" required value="<?= htmlspecialchars($_POST['nama'] ?? $data['nama']) ?>"></label>
<label>Telp<input type="text" name="telp" maxlength="12" required value="<?= htmlspecialchars($_POST['telp'] ?? $data['telp']) ?>"></label>
<label>Alamat<textarea name="alamat" required><?= htmlspecialchars($_POST['alamat'] ?? $data['alamat']) ?></textarea></label>
<div class="form-actions"><button class="btn success" type="submit">Update</button><a class="btn danger" href="supplier.php">Batal</a></div>
</form></main></div></body></html>
