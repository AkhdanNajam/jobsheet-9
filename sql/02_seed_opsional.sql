-- OPSIONAL: data awal dari data/buku.json & data/anggota.json (Jobsheet 6)
-- Jalankan: psql -U postgres -d simpus_mini -f sql/02_seed_opsional.sql

INSERT INTO buku (judul, pengarang, tahun, stok, kategori) VALUES
    ('Laskar Pelangi', 'Andrea Hirata', 2005, 4, 'fiksi'),
    ('Bumi Manusia', 'Pramoedya Ananta Toer', 1980, 2, 'fiksi'),
    ('Negeri 5 Menara', 'Ahmad Fuadi', 2009, 0, 'fiksi'),
    ('Filosofi Teras', 'Henry Manampiring', 2018, 5, 'non-fiksi'),
    ('Ronggeng Dukuh Paruk', 'Ahmad Tohari', 1982, 1, 'fiksi'),
    ('Cantik Itu Luka', 'Eka Kurniawan', 2002, 3, 'fiksi'),
    ('Pulang', 'Tere Liye', 2015, 2, 'fiksi'),
    ('Sang Pemimpi', 'Andrea Hirata', 2006, 6, 'fiksi'),
    ('Perahu Kertas', 'Dee Lestari', 2009, 0, 'fiksi'),
    ('Gadis Kretek', 'Ratih Kumala', 2012, 4, 'fiksi');

INSERT INTO anggota (nama, no_anggota, alamat, no_hp) VALUES
    ('Siti Aminah', 'A001', 'Malang', '0812xxxx'),
    ('Budi Santoso', 'A002', 'Batu', '0813xxxx'),
    ('Dewi Lestari', 'A003', 'Malang', '0814xxxx'),
    ('Rizky Firmansyah', 'A004', 'Lawang', '0815xxxx');
