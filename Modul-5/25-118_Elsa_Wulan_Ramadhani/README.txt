PRAKTIKUM MODUL 5 - DATABASE PENJUALAN
Teknologi: PHP Native, MySQL, XAMPP

CARA MENJALANKAN:
1. Ekstrak folder modul5_database ke C:\xampp\htdocs\
2. Jalankan Apache dan MySQL melalui XAMPP Control Panel.
3. Buka http://localhost/phpmyadmin
4. Pilih menu Import, pilih file database.sql dari folder ini, lalu klik Import/Go.
5. Buka http://localhost/modul5_database/
6. Pilih Data Master Supplier untuk mencoba tambah, edit, dan hapus data.

ISI PROJECT:
- database.sql: membuat database db_penjualan, 7 tabel, dan minimal 10 data contoh pada setiap tabel.
- koneksi.php: koneksi PHP ke MySQL.
- index.php: dashboard dan navigasi.
- supplier.php: menampilkan data supplier.
- tambah_supplier.php: form tambah supplier.
- edit_supplier.php: form edit supplier.
- hapus_supplier.php: proses hapus dengan popup konfirmasi dari halaman supplier.
- tabel.php: menampilkan data dari tabel lainnya.

CATATAN:
- Database memakai nama db_penjualan.
- Akun MySQL default XAMPP: user root tanpa password. Jika konfigurasi MySQL kamu berbeda, ubah koneksi.php.
- Data contoh dibuat untuk keperluan praktikum dan bukan data perusahaan nyata.
- Data supplier yang masih dipakai pada tabel barang tidak bisa dihapus karena aturan foreign key. Hapus/ubah relasi barang terlebih dahulu.
