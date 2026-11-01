CREATE DATABASE IF NOT EXISTS db_penjualan;
USE db_penjualan;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS transaksi_detail;
DROP TABLE IF EXISTS pembayaran;
DROP TABLE IF EXISTS transaksi;
DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS supplier;
DROP TABLE IF EXISTS pelanggan;
DROP TABLE IF EXISTS `user`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE pelanggan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  telp VARCHAR(12) NOT NULL,
  alamat TEXT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE supplier (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  telp VARCHAR(12) NOT NULL,
  alamat TEXT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(10) NOT NULL,
  nama_barang VARCHAR(100) NOT NULL,
  harga INT NOT NULL,
  stok INT NOT NULL,
  supplier_id INT NOT NULL,
  CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id) REFERENCES supplier(id)
) ENGINE=InnoDB;

CREATE TABLE `user` (
  id_user TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(20) NOT NULL,
  password VARCHAR(35) NOT NULL,
  nama VARCHAR(50) NOT NULL,
  alamat VARCHAR(150) NOT NULL,
  hp VARCHAR(20) NOT NULL,
  level TINYINT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  waktu_transaksi DATETIME NOT NULL,
  keterangan TEXT,
  total INT NOT NULL,
  pelanggan_id INT NOT NULL,
  CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
) ENGINE=InnoDB;

CREATE TABLE transaksi_detail (
  transaksi_id INT NOT NULL,
  barang_id INT NOT NULL,
  harga INT NOT NULL,
  qty INT NOT NULL,
  PRIMARY KEY (transaksi_id, barang_id),
  CONSTRAINT fk_detail_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi(id),
  CONSTRAINT fk_detail_barang FOREIGN KEY (barang_id) REFERENCES barang(id)
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  waktu_bayar DATETIME NOT NULL,
  total INT NOT NULL,
  metode ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
  transaksi_id INT NOT NULL,
  CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
) ENGINE=InnoDB;

INSERT INTO pelanggan (nama,jenis_kelamin,telp,alamat) VALUES
('Andi Saputra','L','081234560001','Surabaya'),
('Budi Santoso','L','081234560002','Bangkalan'),
('Citra Lestari','P','081234560003','Madura'),
('Dewi Anggraini','P','081234560004','Sidoarjo'),
('Eko Prasetyo','L','081234560005','Gresik'),
('Fitri Amelia','P','081234560006','Lamongan'),
('Galih Pratama','L','081234560007','Tuban'),
('Hana Putri','P','081234560008','Pamekasan'),
('Indra Wijaya','L','081234560009','Surabaya'),
('Jihan Safitri','P','081234560010','Sumenep');

INSERT INTO supplier (nama,telp,alamat) VALUES
('PT. Maju Bersama','08123456','Surabaya'),
('PT. Senang Sekali','081515563','Bangkalan'),
('PT. Segar Segar','0845454663','Surabaya'),
('CV. Sumber Rezeki','08123457','Sidoarjo'),
('PT. Makmur Jaya','08123458','Gresik'),
('CV. Berkah Abadi','08123459','Madura'),
('PT. Karya Mandiri','08123460','Lamongan'),
('CV. Mitra Usaha','08123461','Tuban'),
('PT. Sinar Terang','08123462','Pamekasan'),
('CV. Indo Niaga','08123463','Sumenep');

INSERT INTO barang (kode_barang,nama_barang,harga,stok,supplier_id) VALUES
('BRG001','Buku Tulis',5000,100,1),
('BRG002','Pulpen',3000,150,2),
('BRG003','Pensil',2500,120,3),
('BRG004','Penghapus',1500,90,4),
('BRG005','Penggaris',4000,80,5),
('BRG006','Spidol',7000,60,6),
('BRG007',' map Plastik',2000,110,7),
('BRG008','Buku Gambar',8000,70,8),
('BRG009','Stabilo',6000,50,9),
('BRG010','Kertas A4',45000,40,10);

INSERT INTO `user` (username,password,nama,alamat,hp,level) VALUES
('admin01','admin123','Admin Satu','Surabaya','081300000001',1),
('kasir01','kasir123','Kasir Satu','Bangkalan','081300000002',2),
('kasir02','kasir123','Kasir Dua','Madura','081300000003',2),
('operator1','ops123','Operator Satu','Sidoarjo','081300000004',2),
('operator2','ops123','Operator Dua','Gresik','081300000005',2),
('staff01','staff123','Staff Satu','Lamongan','081300000006',2),
('staff02','staff123','Staff Dua','Tuban','081300000007',2),
('staff03','staff123','Staff Tiga','Pamekasan','081300000008',2),
('staff04','staff123','Staff Empat','Sumenep','081300000009',2),
('admin02','admin123','Admin Dua','Surabaya','081300000010',1);

INSERT INTO transaksi (waktu_transaksi,keterangan,total,pelanggan_id) VALUES
('2026-10-01 09:00:00','Pembelian alat tulis',11000,1),
('2026-10-01 10:00:00','Pembelian perlengkapan',6000,2),
('2026-10-02 11:00:00','Pembelian barang',7500,3),
('2026-10-02 12:00:00','Pembelian alat sekolah',1500,4),
('2026-10-03 09:30:00','Pembelian barang',8000,5),
('2026-10-03 13:00:00','Pembelian spidol',7000,6),
('2026-10-04 14:00:00','Pembelian map',4000,7),
('2026-10-05 08:30:00','Pembelian buku gambar',16000,8),
('2026-10-05 10:30:00','Pembelian stabilo',12000,9),
('2026-10-06 15:00:00','Pembelian kertas',45000,10);

INSERT INTO transaksi_detail (transaksi_id,barang_id,harga,qty) VALUES
(1,1,5000,2),(2,2,3000,2),(3,3,2500,3),(4,4,1500,1),(5,5,4000,2),
(6,6,7000,1),(7,7,2000,2),(8,8,8000,2),(9,9,6000,2),(10,10,45000,1);

INSERT INTO pembayaran (waktu_bayar,total,metode,transaksi_id) VALUES
('2026-10-01 09:05:00',10000,'TUNAI',1),
('2026-10-01 10:05:00',6000,'TRANSFER',2),
('2026-10-02 11:05:00',7500,'EDC',3),
('2026-10-02 12:05:00',1500,'TUNAI',4),
('2026-10-03 09:35:00',8000,'TRANSFER',5),
('2026-10-03 13:05:00',7000,'EDC',6),
('2026-10-04 14:05:00',4000,'TUNAI',7),
('2026-10-05 08:35:00',16000,'TRANSFER',8),
('2026-10-05 10:35:00',12000,'EDC',9),
('2026-10-06 15:05:00',45000,'TUNAI',10);
