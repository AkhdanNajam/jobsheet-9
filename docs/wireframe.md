# Wireframe & User Flow - SIMPUS-Mini

## Wireframe Login

+--------------------------------------+
| SIMPUS-Mini                          |
|--------------------------------------|
|                                      |
|          [ Login Petugas ]           |
|                                      |
| Username : [______________]          |
| Password : [______________]          |
|                                      |
|             [ Masuk ]                |
|                                      |
| Belum punya akun? Daftar di sini     |
+--------------------------------------+


## Wireframe Dashboard Petugas

+-----------------------------------------------------+
| SIMPUS-Mini | Beranda | Buku | Anggota | Peminjaman | (Nama Petugas) Logout |
|-----------------------------------------------------|
| [Total Buku] [Total Anggota] [Sedang Dipinjam]      |
|                                                     |
| Aksi Cepat:                                         |
| [ + Peminjaman Baru ] [ + Pengembalian ]            |
|                                                     |
| Transaksi Terbaru                                   |
| Anggota | Buku | Tgl Pinjam | Status                |
+-----------------------------------------------------+


## Wireframe Form Peminjaman

+--------------------------------------+
| Form Peminjaman Buku                 |
|--------------------------------------|
| Anggota : [ dropdown pilih anggota ] |
| Buku    : [ dropdown, hanya stok>0 ] |
| Tanggal Pinjam : [ auto: hari ini ]  |
|                                      |
|        [ Simpan Peminjaman ]         |
+--------------------------------------+


## Wireframe Form Pengembalian

+--------------------------------------+
| Pengembalian Buku                    |
|--------------------------------------|
| Cari transaksi aktif:                |
| [ nama anggota / judul buku ______ ] |
|                                      |
| Anggota | Buku | Tgl Pinjam | Aksi   |
|         |      |            | [Kembalikan] |
+--------------------------------------+


## Wireframe Riwayat Peminjaman per Anggota

+--------------------------------------+
| Riwayat Peminjaman - Siti Aminah     |
|--------------------------------------|
| Buku            | Pinjam | Kembali | Status |
| Laskar Pelangi  | 01/07  | 10/07   | Selesai |
| Bumi Manusia    | 15/07  | -       | Dipinjam |
+--------------------------------------+


## User Flow — Peminjaman Buku

[Petugas Login]
       ↓
[Dashboard]
       ↓
[Pilih menu "Peminjaman Baru"]
       ↓
[Pilih Anggota]
       ↓
[Pilih Buku (stok > 0)]
       ↓
[Simpan]
       ↓
[Stok buku berkurang 1]
       ↓
[Kembali ke Dashboard]

Catatan:
- Buku dengan stok 0 tidak dapat dipilih.
- Setelah peminjaman disimpan, stok buku berkurang 1.


## User Flow — Pengembalian Buku

[Dashboard]
       ↓
[Menu "Pengembalian"]
       ↓
[Cari transaksi aktif (anggota/buku)]
       ↓
[Tandai "Dikembalikan"]
       ↓
[Stok buku bertambah 1]
       ↓
[Kembali ke Dashboard]

Catatan:
- Pengembalian dilakukan dengan mencari transaksi peminjaman yang masih aktif.
- Setelah buku dikembalikan, stok buku bertambah 1.


## Aktor

- Tamu: hanya bisa melihat katalog buku (Beranda, Daftar Buku) tanpa login.
- Petugas: login untuk mengakses seluruh fitur CRUD dan transaksi peminjaman.


## Otorisasi

- Tamu dapat mengakses Beranda dan Daftar Buku tanpa login.
- Petugas harus login terlebih dahulu untuk mengakses Dashboard dan fitur transaksi.
- Jika Tamu mencoba membuka halaman transaksi, pengguna diarahkan ke halaman Login.


## Konsistensi dengan Desain yang Sudah Berjalan

Wireframe yang dibuat tetap mengikuti desain yang sudah digunakan pada Jobsheet sebelumnya.

Hal yang digunakan kembali:
- style.css
- Navbar
- Warna dan typography
- Card
- Tabel
- Form

- Navbar akan ditambah menu Peminjaman dan indikator status login, yaitu nama petugas dan tombol Logout, saat fitur mulai diimplementasikan.
- Edge case buku stok habis dan anggota dengan tunggakan perlu divalidasi saat implementasi fitur transaksi.


## Edge Case

### 1. Stok Buku Habis

Jika stok buku bernilai 0, buku tidak dapat dipilih untuk peminjaman.

### 2. Anggota Memiliki Tunggakan

Jika anggota memiliki kewajiban pengembalian yang sudah melewati jatuh tempo, sistem perlu melakukan validasi sebelum peminjaman baru dilakukan.


## Latihan 1 — Wireframe Registrasi Anggota Baru

+--------------------------------------+
| SIMPUS-Mini                          |
|--------------------------------------|
|      Registrasi Anggota Baru        |
|                                      |
| Nama      : [______________]         |
| Alamat    : [______________]         |
| No. Telp  : [______________]         |
|                                      |
|            [ Daftar ]                |
|            [ Batal ]                 |
+--------------------------------------+


## Latihan 2 — User Flow Mencari Anggota yang Memiliki Tunggakan

[Petugas Login]
       ↓
[Dashboard]
       ↓
[Menu Anggota]
       ↓
[Cari Anggota]
       ↓
[Periksa Tunggakan]
       ↓
[Hasil Pemeriksaan]


## Latihan 3 — Edge Case Tambahan

Jika Petugas mencoba meminjamkan buku yang sama kepada anggota yang sama sebelum buku tersebut dikembalikan, sistem harus memberikan peringatan dan mencegah peminjaman ganda.

[Buku masih dipinjam]
          ↓
[Petugas mencoba meminjamkan lagi]
          ↓
[Tampilkan peringatan]
          ↓
[Peminjaman ditolak]


## Latihan 4 — Implementasi Login

Login diimplementasikan dalam bentuk HTML statis berdasarkan wireframe Login.

Elemen yang digunakan:
- Label Username
- Input Username
- Label Password
- Input Password dengan type="password"
- Tombol Masuk

Implementasi ini hanya berupa tampilan statis dan belum menggunakan logika login atau database.