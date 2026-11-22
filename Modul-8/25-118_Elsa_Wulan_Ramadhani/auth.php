<?php
// Fungsi bantu autentikasi & session. Wajib di-include PALING ATAS sebelum ada output HTML.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function sudah_login() {
    return isset($_SESSION['id_user']);
}

// Proteksi halaman: belum login -> arahkan ke login.php
function wajib_login() {
    if (!sudah_login()) {
        header("Location: login.php");
        exit;
    }
}

// Proteksi berdasarkan level. Contoh: wajib_level([1]) hanya untuk owner.
function wajib_level(array $level_boleh) {
    wajib_login();
    if (!in_array((int) $_SESSION['level'], $level_boleh, true)) {
        header("Location: index.php?pesan=akses");
        exit;
    }
}

// Proteksi halaman login: sudah login -> tidak boleh membuka login.php
function wajib_tamu() {
    if (sudah_login()) {
        header("Location: index.php");
        exit;
    }
}

function is_owner() {
    return sudah_login() && (int) $_SESSION['level'] === 1;
}

function e($teks) {
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

function rp($angka) {
    return "Rp " . number_format((float) $angka, 0, ',', '.');
}

// Pesan flash (tampil sekali setelah redirect)
function set_flash($pesan, $jenis = 'ok') {
    $_SESSION['flash'] = ['pesan' => $pesan, 'jenis' => $jenis];
}

function get_flash() {
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $f;
}

// Menyimpan input form (kecuali password) agar tidak hilang saat validasi gagal
function set_old(array $input) {
    unset($input['password']);
    $_SESSION['old'] = $input;
}

// Mengambil nilai input lama (hanya sekali pakai per halaman)
function old($kunci, $default = '') {
    static $old = null;
    if ($old === null) {
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);
    }
    return $old[$kunci] ?? $default;
}
