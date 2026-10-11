<?php
require __DIR__ . '/../includes/koneksi.php';

// ===== Pagination & pencarian sisi server =====
$perPage = 5;
$keyword = trim($_GET['q'] ?? '');
$page    = max(1, (int) ($_GET['page'] ?? 1));

// 1) Hitung total baris (mengikuti pencarian, kalau ada)
if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = (int) $hitung->fetchColumn();
} else {
    $totalRows = (int) $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
}

// 2) Total halaman, lalu pastikan $page tidak melewati halaman terakhir
$totalPages = max(1, (int) ceil($totalRows / $perPage));
$page       = min($page, $totalPages);
$offset     = ($page - 1) * $perPage;

// 3) Ambil data untuk halaman yang sedang dibuka
if ($keyword !== '') {
    $stmt = $pdo->prepare(
    "SELECT * FROM buku WHERE judul ILIKE :kw OR pengarang ILIKE :kw
     ORDER BY id DESC LIMIT :limit OFFSET :offset"
    );
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $stmt = $pdo->prepare("SELECT * FROM buku ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);

$base = '../';
$judulHalaman = 'Daftar Buku';
include __DIR__ . '/../includes/header.php';
?>

        <section>
            <h2>Daftar Buku</h2>

            <div class="search-box">
                <form method="get" action="list.php">
                    <span>
                        <label for="search-input">Cari Judul Buku</label>
                        <input type="text" id="search-input" name="q" data-search-column="0"
                               value="<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"
                               placeholder="Ketik judul buku...">
                    </span>
                    <button type="submit">Cari</button>
                </form>
            </div>

            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($daftarBuku)): ?>
                    <tr><td colspan="6">Belum ada data buku.</td></tr>
                <?php endif; ?>
                <?php foreach ($daftarBuku as $buku): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($buku['judul']); ?></td>
                        <td><?php echo htmlspecialchars($buku['pengarang']); ?></td>
                        <td><?php echo $buku['tahun']; ?></td>
                        <td><?php echo $buku['stok']; ?></td>
                        <td><?php echo htmlspecialchars($buku['kategori'] ?? 'Tidak ada kategori'); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $buku['id']; ?>" class="btn-edit">Edit</a>
                            <form class="form-hapus" method="post" action="hapus.php">
                                <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
                                <button type="submit" class="btn-hapus">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>

            <nav class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&amp;q=' . urlencode($keyword) : ''; ?>"
                       class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </nav>
        </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
