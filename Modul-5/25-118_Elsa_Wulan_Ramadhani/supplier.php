<?php
require_once "koneksi.php";
$data = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Data Master Supplier</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<header><h1>Data Master Supplier</h1><p>Daftar supplier yang tersimpan di database</p></header>
<main>
  <div class="top-actions">
    <a class="btn secondary" href="index.php">Kembali</a>
    <a class="btn success" href="tambah_supplier.php">+ Tambah Data</a>
  </div>
  <?php if (isset($_GET['pesan'])): ?>
    <div class="alert"><?= htmlspecialchars($_GET['pesan']) ?></div>
  <?php endif; ?>
  <div class="table-wrap">
  <table>
    <thead><tr><th>No</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Tindakan</th></tr></thead>
    <tbody>
    <?php $no=1; while($row=mysqli_fetch_assoc($data)): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['telp']) ?></td>
        <td><?= htmlspecialchars($row['alamat']) ?></td>
        <td class="actions">
          <a class="btn warning" href="edit_supplier.php?id=<?= $row['id'] ?>">Edit</a>
          <a class="btn danger" href="hapus_supplier.php?id=<?= $row['id'] ?>" onclick="return confirm('Anda yakin akan menghapus supplier ini?')">Hapus</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
  </div>
</main>
</div>
</body>
</html>
