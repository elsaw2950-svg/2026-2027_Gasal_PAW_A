<?php
require "koneksi.php";
if ($_SERVER["REQUEST_METHOD"]!=="POST") { header("Location: index.php"); exit; }
$transaksi_id=filter_input(INPUT_POST,"transaksi_id",FILTER_VALIDATE_INT);
$barang_id=filter_input(INPUT_POST,"barang_id",FILTER_VALIDATE_INT);
$qty=filter_input(INPUT_POST,"qty",FILTER_VALIDATE_INT);
if (!$transaksi_id || !$barang_id || !$qty || $qty<1) { die("Input tidak valid."); }

mysqli_begin_transaction($koneksi);
try {
    // Kunci transaksi dan barang untuk menghindari input ganda secara bersamaan.
    $q=mysqli_prepare($koneksi,"SELECT id FROM transaksi WHERE id=? FOR UPDATE");
    mysqli_stmt_bind_param($q,"i",$transaksi_id); mysqli_stmt_execute($q);
    if (!mysqli_fetch_assoc(mysqli_stmt_get_result($q))) { throw new Exception("Transaksi tidak ditemukan."); }

    $q=mysqli_prepare($koneksi,"SELECT harga,stok FROM barang WHERE id=? FOR UPDATE");
    mysqli_stmt_bind_param($q,"i",$barang_id); mysqli_stmt_execute($q);
    $barang=mysqli_fetch_assoc(mysqli_stmt_get_result($q));
    if (!$barang) { throw new Exception("Barang tidak ditemukan."); }
    if ($qty>(int)$barang["stok"]) { throw new Exception("Qty melebihi stok barang."); }

    $q=mysqli_prepare($koneksi,"SELECT barang_id FROM transaksi_detail WHERE transaksi_id=? AND barang_id=?");
    mysqli_stmt_bind_param($q,"ii",$transaksi_id,$barang_id); mysqli_stmt_execute($q);
    if (mysqli_fetch_assoc(mysqli_stmt_get_result($q))) { throw new Exception("Barang sudah ada pada detail transaksi ini."); }

    $harga=(int)$barang["harga"];
    $q=mysqli_prepare($koneksi,"INSERT INTO transaksi_detail(transaksi_id,barang_id,harga,qty) VALUES(?,?,?,?)");
    mysqli_stmt_bind_param($q,"iiii",$transaksi_id,$barang_id,$harga,$qty);
    if (!mysqli_stmt_execute($q)) { throw new Exception("Gagal menyimpan detail."); }

    $q=mysqli_prepare($koneksi,"UPDATE barang SET stok=stok-? WHERE id=?");
    mysqli_stmt_bind_param($q,"ii",$qty,$barang_id); mysqli_stmt_execute($q);

    // Hitung ulang total dari seluruh detail transaksi yang sama.
    $q=mysqli_prepare($koneksi,"UPDATE transaksi SET total=(SELECT COALESCE(SUM(harga*qty),0) FROM transaksi_detail WHERE transaksi_id=?) WHERE id=?");
    mysqli_stmt_bind_param($q,"ii",$transaksi_id,$transaksi_id); mysqli_stmt_execute($q);

    mysqli_commit($koneksi);
    header("Location: detail.php?id=".$transaksi_id."&pesan=berhasil"); exit;
} catch (Throwable $e) {
    mysqli_rollback($koneksi);
    echo "<p>Gagal: ".htmlspecialchars($e->getMessage())."</p><p><a href='detail.php?id=".(int)$transaksi_id."'>Kembali</a></p>";
}
