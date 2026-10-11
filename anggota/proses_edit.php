<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: list.php');
    exit;
}

$nama       = trim($_POST['nama'] ?? '');
$no_anggota = trim($_POST['no_anggota'] ?? '');
$alamat     = trim($_POST['alamat'] ?? '');
$no_hp      = trim($_POST['no_hp'] ?? '');

// ===== Validasi (identik dengan proses_tambah.php) =====
$errors = [];

if ($nama === '') {
    $errors[] = 'Nama wajib diisi.';
}
if ($no_anggota === '') {
    $errors[] = 'No. Anggota wajib diisi.';
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode((string) $id));
    exit;
}

// ===== UPDATE (WHERE id = :id wajib ada!) =====
try {
    $stmt = $pdo->prepare(
        "UPDATE anggota
         SET nama = :nama, no_anggota = :no_anggota, alamat = :alamat, no_hp = :no_hp
         WHERE id = :id"
    );

    $stmt->execute([
        'nama'       => $nama,
        'no_anggota' => $no_anggota,
        'alamat'     => $alamat !== '' ? $alamat : null,
        'no_hp'      => $no_hp !== '' ? $no_hp : null,
        'id'         => $id,
    ]);
} catch (PDOException $e) {
    // 23505 = unique_violation (no_anggota sudah dipakai anggota lain)
    if ($e->getCode() === '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'No. Anggota sudah dipakai anggota lain.'];
        header('Location: edit.php?id=' . urlencode((string) $id));
        exit;
    }
    throw $e;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil diperbarui.'];
header('Location: list.php');
exit;
