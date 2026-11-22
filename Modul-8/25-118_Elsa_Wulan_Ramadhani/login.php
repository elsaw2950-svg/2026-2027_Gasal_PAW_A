<?php
require_once "koneksi.php";
require_once "auth.php";

// Jika sudah login, tidak boleh membuka halaman login
wajib_tamu();

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi input
    if ($username === '' || $password === '') {
        $error = "Username dan password wajib diisi.";
    } else {
        $stmt = mysqli_prepare($koneksi, "SELECT id_user, username, password, nama, level FROM `user` WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);

        if (!$user || !hash_equals((string) $user['password'], $password)) {
            $error = "Username atau password salah.";
        } elseif (!in_array((int) $user['level'], [1, 2], true)) {
            $error = "Level user ini tidak memiliki akses ke sistem.";
        } else {
            // Set session
            session_regenerate_id(true);
            $_SESSION['id_user']  = (int) $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama']     = $user['nama'];
            $_SESSION['level']    = (int) $user['level'];
            header("Location: index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; background: #1f3a93; margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #fff; width: 100%; max-width: 360px; padding: 28px; border-radius: 6px; box-shadow: 0 4px 14px rgba(0,0,0,.3); }
        h2 { margin: 0 0 4px; text-align: center; }
        p.sub { margin: 0 0 18px; text-align: center; color: #666; font-size: 14px; }
        label { display: block; margin: 12px 0 4px; font-size: 14px; font-weight: bold; }
        input { width: 100%; padding: 9px; border: 1px solid #bbb; border-radius: 3px; font-size: 14px; box-sizing: border-box; }
        button { width: 100%; margin-top: 18px; padding: 10px; background: #1f3a93; color: #fff; border: 0; border-radius: 3px; font-size: 15px; cursor: pointer; }
        .error { background: #fbe0e0; border: 1px solid #e29a9a; padding: 9px 12px; border-radius: 3px; font-size: 14px; margin-bottom: 6px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Sistem Penjualan</h2>
        <p class="sub">Silakan login untuk melanjutkan</p>
        <?php if ($error !== ''): ?>
            <div class="error"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="post" action="login.php" autocomplete="off">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= e($username) ?>" maxlength="30" required autofocus>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" maxlength="35" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
