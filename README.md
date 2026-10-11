# Jobsheet 9 - CRUD Penuh PostgreSQL (SIMPUS-Mini)

Lanjutan dari Jobsheet 8 (Create & Read). Jobsheet ini melengkapi
**Update** dan **Delete**, ditambah pagination dan pencarian sisi server.

## Yang baru
1. `edit.php` + `proses_edit.php` (buku & anggota): form terisi data lama, lalu `UPDATE`.
2. `hapus.php` (buku & anggota): `DELETE`, sengaja hanya menerima **POST**
   agar tidak terpicu lewat tautan biasa / crawler.
3. Tombol Hapus di `list.php` kini berupa `<form>` sungguhan; `app.js`
   menangani konfirmasi pada event `submit` (bukan `click`).
4. Pagination (`LIMIT`/`OFFSET`, 5 baris per halaman) dan pencarian
   sisi server (`WHERE ... ILIKE ...`).

## Persiapan
Sama seperti Jobsheet 8 (database `simpus_mini` + `sql/01_buku_anggota.sql`).
Opsional: `sql/02_seed_opsional.sql` untuk data awal.

## Menjalankan
`php -S localhost:8000` di folder ini, lalu buka `http://localhost:8000/index.php`
(atau taruh di `C:\laragon\www\`).

## Catatan
- Kolom pencarian melayani dua peran: filter instan sisi klien (JavaScript)
  untuk baris yang tampil, dan pencarian penuh lintas halaman lewat tombol "Cari".
- Nilai pencarian (`q`) dan data pada form edit di-escape dengan `htmlspecialchars()`.
  (Audit keamanan menyeluruh tetap dibahas di Jobsheet 11.)
