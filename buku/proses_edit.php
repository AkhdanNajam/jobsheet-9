<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

// id datang dari <input type="hidden"> (POST), bukan dari URL
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: list.php');
    exit;
}

$judul     = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun     = trim($_POST['tahun'] ?? '');
$isbn      = trim($_POST['isbn'] ?? '');
$stok      = trim($_POST['stok'] ?? '');
$kategori  = trim($_POST['kategori'] ?? '');

// ===== Validasi server-side (identik dengan proses_tambah.php) =====
$errors = [];

if ($judul === '') {
    $errors[] = 'Judul wajib diisi.';
}
if ($pengarang === '') {
    $errors[] = 'Pengarang wajib diisi.';
}
if (!is_numeric($tahun) || (int) $tahun < 1900 || (int) $tahun > 2026) {
    $errors[] = 'Tahun harus berupa angka antara 1900-2026.';
}
if (!is_numeric($stok) || (int) $stok < 0) {
    $errors[] = 'Stok harus berupa angka dan tidak boleh negatif.';
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode((string) $id));
    exit;
}

// ===== UPDATE (WHERE id = :id wajib ada!) =====
$stmt = $pdo->prepare(
    "UPDATE buku
     SET judul = :judul, pengarang = :pengarang, tahun = :tahun,
         isbn = :isbn, stok = :stok, kategori = :kategori
     WHERE id = :id"
);

$stmt->execute([
    'judul'     => $judul,
    'pengarang' => $pengarang,
    'tahun'     => (int) $tahun,
    'isbn'      => $isbn !== '' ? $isbn : null,
    'stok'      => (int) $stok,
    'kategori'  => $kategori,
    'id'        => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil diperbarui.'];
header('Location: list.php');
exit;
