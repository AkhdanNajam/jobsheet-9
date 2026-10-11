<?php
// Variabel yang diset halaman pemanggil sebelum include header:
//   $base         -> '' (folder root) atau '../' (folder buku/ & anggota/)
//   $judulHalaman -> judul untuk <title>
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base = $base ?? '';
$judulHalaman = $judulHalaman ?? 'SIMPUS-Mini';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPUS-Mini | <?php echo htmlspecialchars($judulHalaman); ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>

    <header>
        <h1>SIMPUS-Mini</h1>

        <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>

        <nav>
            <ul>
                <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                <li><a href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>
                <li><a href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
                <li><a href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
                <li><a href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
            </ul>
        </nav>
    </header>

    <main>
<?php
// Flash message: tampil sekali, lalu dihapus dari session
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    $tipe = $flash['type'] === 'success' ? 'flash-success' : 'flash-error';
    echo '<div class="flash ' . $tipe . '">' . htmlspecialchars($flash['pesan']) . '</div>';
}
?>
