<?php
require_once "koneksi.php";
$jumlahSupplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM supplier"))['jumlah'];
$jumlahBarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM barang"))['jumlah'];
$jumlahPelanggan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM pelanggan"))['jumlah'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Database Penjualan</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <header><h1>Database Penjualan</h1><p>Praktikum Modul 5 - Database</p></header>
  <main>
    <h2>Dashboard</h2>
    <div class="cards">
      <div class="card"><span>Data Supplier</span><strong><?= $jumlahSupplier ?></strong></div>
      <div class="card"><span>Data Barang</span><strong><?= $jumlahBarang ?></strong></div>
      <div class="card"><span>Data Pelanggan</span><strong><?= $jumlahPelanggan ?></strong></div>
    </div>
    <h3>Menu Data</h3>
    <div class="menu">
      <a href="supplier.php">Data Master Supplier</a>
      <a href="tabel.php?t=pelanggan">Data Pelanggan</a>
      <a href="tabel.php?t=barang">Data Barang</a>
      <a href="tabel.php?t=transaksi">Data Transaksi</a>
      <a href="tabel.php?t=transaksi_detail">Detail Transaksi</a>
      <a href="tabel.php?t=pembayaran">Data Pembayaran</a>
      <a href="tabel.php?t=user">Data User</a>
    </div>
  </main>
</div>
</body>
</html>
