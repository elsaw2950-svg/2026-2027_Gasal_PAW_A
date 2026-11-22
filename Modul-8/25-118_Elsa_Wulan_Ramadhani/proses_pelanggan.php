<?php
// PROSES SIMPAN PELANGGAN: aksi=tambah (INSERT) atau aksi=edit (UPDATE)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: pelanggan.php"); exit; }

$aksi = $_POST['aksi'] ?? '';
$id = trim($_POST['id'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$jk = $_POST['jenis_kelamin'] ?? '';
$telp = trim($_POST['telp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');

$kembali = $aksi === 'edit' ? "edit_pelanggan.php?id=" . urlencode($id) : "tambah_pelanggan.php";

try {
    if (!in_array($aksi, ['tambah', 'edit'], true)) { throw new Exception("Aksi tidak valid."); }
    if ($id === '' || $nama === '' || !in_array($jk, ['L', 'P'], true)) {
        throw new Exception("ID, nama, dan jenis kelamin wajib diisi.");
    }
    if ($telp !== '' && !preg_match('/^[0-9]{1,12}$/', $telp)) {
        throw new Exception("Telp harus berupa angka (maksimal 12 digit).");
    }

    if ($aksi === 'tambah') {
        $q = mysqli_prepare($koneksi, "INSERT INTO pelanggan (id,nama,jenis_kelamin,telp,alamat) VALUES (?,?,?,?,?)");
        mysqli_stmt_bind_param($q, "sssss", $id, $nama, $jk, $telp, $alamat);
        mysqli_stmt_execute($q);
        set_flash("Data pelanggan berhasil ditambahkan.");
    } else {
        $q = mysqli_prepare($koneksi, "UPDATE pelanggan SET nama=?, jenis_kelamin=?, telp=?, alamat=? WHERE id=?");
        mysqli_stmt_bind_param($q, "sssss", $nama, $jk, $telp, $alamat, $id);
        mysqli_stmt_execute($q);
        set_flash("Data pelanggan berhasil diubah.");
    }
    header("Location: pelanggan.php");
    exit;
} catch (mysqli_sql_exception $ex) {
    set_flash($ex->getCode() == 1062 ? "ID pelanggan sudah digunakan." : "Terjadi kesalahan database.", 'err');
} catch (Exception $ex) {
    set_flash($ex->getMessage(), 'err');
}
set_old($_POST);
header("Location: " . $kembali);
exit;
