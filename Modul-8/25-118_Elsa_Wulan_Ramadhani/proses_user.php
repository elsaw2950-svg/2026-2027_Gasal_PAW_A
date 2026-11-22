<?php
// PROSES SIMPAN USER: aksi=tambah (INSERT) atau aksi=edit (UPDATE)
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1]);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: user.php"); exit; }

$aksi = $_POST['aksi'] ?? '';
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$nama = trim($_POST['nama'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$hp = trim($_POST['hp'] ?? '');
$level = filter_input(INPUT_POST, 'level', FILTER_VALIDATE_INT);

$kembali = $aksi === 'edit' ? "edit_user.php?id=" . (int) $id : "tambah_user.php";

try {
    if (!in_array($aksi, ['tambah', 'edit'], true)) { throw new Exception("Aksi tidak valid."); }
    if ($aksi === 'edit' && !$id) { throw new Exception("ID user tidak valid."); }
    if ($username === '' || $nama === '' || !in_array($level, [1, 2, 3], true)) {
        throw new Exception("Username, nama, dan level wajib diisi.");
    }
    if ($aksi === 'tambah' && $password === '') {
        throw new Exception("Password wajib diisi untuk user baru.");
    }
    if (strlen($password) > 35) {
        throw new Exception("Password maksimal 35 karakter.");
    }
    if ($hp !== '' && !preg_match('/^[0-9]{1,20}$/', $hp)) {
        throw new Exception("No HP harus berupa angka.");
    }
    // Cegah owner menurunkan level akunnya sendiri (agar tidak terkunci dari data master)
    if ($aksi === 'edit' && $id === (int) $_SESSION['id_user'] && $level !== (int) $_SESSION['level']) {
        throw new Exception("Anda tidak dapat mengubah level akun yang sedang digunakan.");
    }

    if ($aksi === 'tambah') {
        $q = mysqli_prepare($koneksi, "INSERT INTO `user` (username,password,nama,alamat,hp,level) VALUES (?,?,?,?,?,?)");
        mysqli_stmt_bind_param($q, "sssssi", $username, $password, $nama, $alamat, $hp, $level);
        mysqli_stmt_execute($q);
        set_flash("Data user berhasil ditambahkan.");
    } else {
        if ($password === '') {
            $q = mysqli_prepare($koneksi, "UPDATE `user` SET username=?, nama=?, alamat=?, hp=?, level=? WHERE id_user=?");
            mysqli_stmt_bind_param($q, "ssssii", $username, $nama, $alamat, $hp, $level, $id);
        } else {
            $q = mysqli_prepare($koneksi, "UPDATE `user` SET username=?, password=?, nama=?, alamat=?, hp=?, level=? WHERE id_user=?");
            mysqli_stmt_bind_param($q, "sssssii", $username, $password, $nama, $alamat, $hp, $level, $id);
        }
        mysqli_stmt_execute($q);
        // Jika yang diubah akun sendiri, perbarui session agar nama di navbar ikut berubah
        if ($id === (int) $_SESSION['id_user']) {
            $_SESSION['nama'] = $nama;
            $_SESSION['username'] = $username;
        }
        set_flash("Data user berhasil diubah.");
    }
    header("Location: user.php");
    exit;
} catch (mysqli_sql_exception $ex) {
    set_flash($ex->getCode() == 1062 ? "Username sudah digunakan." : "Terjadi kesalahan database.", 'err');
} catch (Exception $ex) {
    set_flash($ex->getMessage(), 'err');
}
set_old($_POST);
header("Location: " . $kembali);
exit;
