<?php
require_once "koneksi.php";
require_once "auth.php";
wajib_login();

$pesan = $_GET['pesan'] ?? '';
$judul = 'Home';

$ringkas = [
    'Transaksi' => (int) mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM transaksi"))[0],
    'Barang'    => (int) mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM barang"))[0],
    'Pelanggan' => (int) mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM pelanggan"))[0],
];
$nama_level = (int) $_SESSION['level'] === 1 ? 'Owner' : 'Kasir';

require "header.php";
?>
<?php if ($pesan === 'akses'): ?>
    <div class="alert err">Anda tidak memiliki hak akses ke halaman tersebut.</div>
<?php endif; ?>

<div class="box">
    <h2>Selamat datang, <?= e($_SESSION['nama']) ?></h2>
    <p>Anda login sebagai <strong><?= e($nama_level) ?></strong> (level <?= (int) $_SESSION['level'] ?>).</p>
</div>

<div class="box">
    <h3>Ringkasan Data</h3>
    <table class="tbl">
        <tr><?php foreach ($ringkas as $k => $v): ?><th><?= e($k) ?></th><?php endforeach; ?></tr>
        <tr><?php foreach ($ringkas as $v): ?><td><?= $v ?></td><?php endforeach; ?></tr>
    </table>
</div>
<?php require "footer.php"; ?>
