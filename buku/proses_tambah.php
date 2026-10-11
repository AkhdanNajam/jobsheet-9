<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$judul     = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun     = trim($_POST['tahun'] ?? '');
$isbn      = trim($_POST['isbn'] ?? '');
$stok      = trim($_POST['stok'] ?? '');
$kategori  = trim($_POST['kategori'] ?? '');

// ===== Validasi server-side (tidak berubah dari jobsheet-07) =====
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
    header('Location: tambah.php');
    exit;
}

// ===== Simpan ke database (menggantikan $_SESSION['buku'][] = ...) =====
$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)
     RETURNING id"
);

$stmt->execute([
    'judul'     => $judul,
    'pengarang' => $pengarang,
    'tahun'     => (int) $tahun,
    'isbn'      => $isbn !== '' ? $isbn : null,
    'stok'      => (int) $stok,
    'kategori'  => $kategori,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil ditambahkan.'];
header('Location: list.php');
exit;
