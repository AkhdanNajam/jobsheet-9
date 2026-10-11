<?php
require __DIR__ . '/../includes/koneksi.php';

// ===== Pagination & pencarian sisi server =====
$perPage = 5;
$keyword = trim($_GET['q'] ?? '');
$page    = max(1, (int) ($_GET['page'] ?? 1));

if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM anggota WHERE nama ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = (int) $hitung->fetchColumn();
} else {
    $totalRows = (int) $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
}

$totalPages = max(1, (int) ceil($totalRows / $perPage));
$page       = min($page, $totalPages);
$offset     = ($page - 1) * $perPage;

if ($keyword !== '') {
    $stmt = $pdo->prepare(
        "SELECT * FROM anggota WHERE nama ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset"
    );
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $stmt = $pdo->prepare("SELECT * FROM anggota ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarAnggota = $stmt->fetchAll(PDO::FETCH_ASSOC);

$base = '../';
$judulHalaman = 'Daftar Anggota';
include __DIR__ . '/../includes/header.php';
?>

        <section>
            <h2>Daftar Anggota</h2>

            <div class="search-box">
                <form method="get" action="list.php">
                    <span>
                        <label for="search-input">Cari Nama Anggota</label>
                        <input type="text" id="search-input" name="q"
                               value="<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"
                               placeholder="Ketik nama anggota...">
                    </span>
                    <button type="submit">Cari</button>
                </form>
            </div>

            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No. Anggota</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($daftarAnggota)): ?>
                    <tr><td colspan="5">Belum ada data anggota.</td></tr>
                <?php endif; ?>
                <?php foreach ($daftarAnggota as $anggota): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($anggota['no_anggota']); ?></td>
                        <td><?php echo htmlspecialchars($anggota['nama']); ?></td>
                        <td><?php echo htmlspecialchars($anggota['alamat'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($anggota['no_hp'] ?? ''); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $anggota['id']; ?>" class="btn-edit">Edit</a>
                            <form class="form-hapus" method="post" action="hapus.php">
                                <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">
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
