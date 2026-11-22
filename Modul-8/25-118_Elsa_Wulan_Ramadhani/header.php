<?php
// Template header + navbar. Set $judul (dan opsional $extra_head) sebelum include.
// Pastikan auth.php sudah di-include sebelum file ini.
$judul = $judul ?? 'Sistem Penjualan';
$extra_head = $extra_head ?? '';
$level = (int) ($_SESSION['level'] ?? 0);
$nama_user = $_SESSION['nama'] ?? '';
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($judul) ?> - Sistem Penjualan</title>
    <?= $extra_head ?>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; margin: 0; color: #222; background: #f5f6f8; }
        .navbar { background: #1f3a93; color: #fff; display: flex; align-items: center; padding: 0 20px; height: 48px; }
        .navbar a { color: #fff; text-decoration: none; }
        .navbar .brand { font-weight: bold; margin-right: 25px; }
        .navbar .menu { display: flex; align-items: center; flex: 1; }
        .navbar .item { position: relative; }
        .navbar .item > a, .navbar .item > span { display: block; padding: 14px 14px; cursor: pointer; font-size: 14px; }
        .navbar .item:hover > a, .navbar .item:hover > span { background: #162b6e; }
        .navbar .dropdown { display: none; position: absolute; top: 48px; left: 0; background: #fff; min-width: 170px; box-shadow: 0 3px 8px rgba(0,0,0,.2); z-index: 20; }
        .navbar .dropdown.kanan { left: auto; right: 0; }
        .navbar .item:hover .dropdown { display: block; }
        .navbar .dropdown a { color: #222; padding: 10px 15px; display: block; font-size: 14px; }
        .navbar .dropdown a:hover { background: #e8ecf7; }
        .navbar .kanan-wrap { margin-left: auto; }
        .container { max-width: 1000px; margin: 25px auto; padding: 0 20px; }
        .box { background: #fff; padding: 20px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,.1); margin-bottom: 20px; }
        table.tbl { border-collapse: collapse; width: 100%; }
        table.tbl th, table.tbl td { border: 1px solid #ccc; padding: 8px 10px; text-align: left; font-size: 14px; }
        table.tbl th { background: #e8ecf7; }
        .alert { padding: 10px 14px; margin-bottom: 15px; border-radius: 3px; font-size: 14px; }
        .alert.ok { background: #dff3df; border: 1px solid #8fcf8f; }
        .alert.err { background: #fbe0e0; border: 1px solid #e29a9a; }
        form.form label { display: block; margin: 10px 0 4px; font-size: 14px; font-weight: bold; }
        form.form input, form.form select, form.form textarea { width: 100%; padding: 8px; border: 1px solid #bbb; border-radius: 3px; font-size: 14px; }
        .btn { display: inline-block; padding: 8px 14px; background: #1f3a93; color: #fff; border: 0; border-radius: 3px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn.abu { background: #777; }
        .btn.merah { background: #c0392b; }
        .btn.kecil { padding: 4px 9px; font-size: 13px; }
        .inline { display: inline; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>
<nav class="navbar no-print">
    <a class="brand" href="index.php">Sistem Penjualan</a>
    <div class="menu">
        <div class="item"><a href="index.php">Home</a></div>

        <?php if ($level === 1): ?>
        <div class="item">
            <span>Data Master &#9662;</span>
            <div class="dropdown">
                <a href="barang.php">Data Barang</a>
                <a href="supplier.php">Data Supplier</a>
                <a href="pelanggan.php">Data Pelanggan</a>
                <a href="user.php">Data User</a>
            </div>
        </div>
        <?php endif; ?>

        <div class="item"><a href="transaksi.php">Transaksi</a></div>
        <div class="item"><a href="laporan.php">Laporan</a></div>
    </div>
    <div class="item kanan-wrap">
        <span><?= e($nama_user) ?> &#9662;</span>
        <div class="dropdown kanan">
            <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
        </div>
    </div>
</nav>
<div class="container">
<?php if ($flash): ?>
    <div class="alert <?= e($flash['jenis']) ?>"><?= e($flash['pesan']) ?></div>
<?php endif; ?>
