<?php
require __DIR__ . '/includes/koneksi.php';

$totalBuku    = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();

$base = '';
$judulHalaman = 'Beranda';
include __DIR__ . '/includes/header.php';
?>

        <section>
            <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
            <p>
                Aplikasi sederhana untuk mengelola data buku
                dan anggota perpustakaan.
            </p>
        </section>

        <section>
            <h2>Ringkasan</h2>

            <article>
                <h3>Total Buku</h3>
                <p><?php echo $totalBuku; ?></p>
            </article>

            <article>
                <h3>Total Anggota</h3>
                <p><?php echo $totalAnggota; ?></p>
            </article>

            <!-- Dua kartu di bawah masih statis (fitur peminjaman belum dibuat) -->
            <article>
                <h3>Sedang Dipinjam</h3>
                <p>3</p>
            </article>

            <article>
                <h3>Buku Terlambat</h3>
                <p>2</p>
            </article>
        </section>

<?php include __DIR__ . '/includes/footer.php'; ?>
