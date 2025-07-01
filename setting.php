<?php
session_start();

// Gunakan path absolut agar tidak salah lokasi
$file = __DIR__ . '/user.json';

// Inisialisasi file jika belum ada
if (!file_exists($file)) {
    file_put_contents($file, json_encode(['username' => 'usm', 'password' => '123']));
}

$userData = file_get_contents($file);
$user = json_decode($userData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("❌ Error membaca JSON: " . json_last_error_msg());
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = trim($_POST['username'] ?? '');
    $new_password = trim($_POST['password'] ?? '');

    if (!empty($new_username) && !empty($new_password)) {
        $user['username'] = $new_username;
        $user['password'] = $new_password;

        // Simpan ke file dan cek apakah berhasil
        $result = file_put_contents($file, json_encode($user, JSON_PRETTY_PRINT));

        if ($result === false) {
            $message = "❌ Gagal menyimpan ke file. Periksa izin file!";
        } else {
            $message = "✅ Username dan password berhasil diperbarui!";
        }
    } else {
        $message = "⚠ Username dan password tidak boleh kosong.";
    }

    // Reload dari file untuk update tampilan input
    $user = json_decode(file_get_contents($file), true);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                Ubah Username & Password
            </div>
            <div class="card-body">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username Baru</label>
                        <input type="text" class="form-control" name="username" id="username"
                            value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="text" class="form-control" name="password" id="password"
                            value="<?= htmlspecialchars($user['password'] ?? '') ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="dashboard_bootstrap.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
