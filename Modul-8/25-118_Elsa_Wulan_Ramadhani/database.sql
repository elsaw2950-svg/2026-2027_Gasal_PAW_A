CREATE DATABASE IF NOT EXISTS penjualan;
USE penjualan;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS pembayaran;
DROP TABLE IF EXISTS transaksi_detail;
DROP TABLE IF EXISTS transaksi;
DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS supplier;
DROP TABLE IF EXISTS pelanggan;
DROP TABLE IF EXISTS user;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(12),
    alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE pelanggan (
    id VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    telp VARCHAR(12),
    alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE `user` (
    id_user TINYINT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(35) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    alamat VARCHAR(150),
    hp VARCHAR(20),
    level TINYINT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10) NOT NULL UNIQUE,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL,
    supplier_id INT NOT NULL,
    CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id)
        REFERENCES supplier(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE NOT NULL,
    keterangan TEXT,
    total INT NOT NULL DEFAULT 0,
    pelanggan_id VARCHAR(20) NOT NULL,
    CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (pelanggan_id)
        REFERENCES pelanggan(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE transaksi_detail (
    transaksi_id INT NOT NULL,
    barang_id INT NOT NULL,
    harga INT NOT NULL,
    qty INT NOT NULL,
    PRIMARY KEY (transaksi_id, barang_id),
    CONSTRAINT fk_detail_transaksi FOREIGN KEY (transaksi_id)
        REFERENCES transaksi(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_detail_barang FOREIGN KEY (barang_id)
        REFERENCES barang(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar DATETIME NOT NULL,
    total INT NOT NULL,
    metode ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
    transaksi_id INT NOT NULL,
    CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id)
        REFERENCES transaksi(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO supplier (nama,telp,alamat) VALUES
('CV Sumber Makmur','081234567801','Surabaya'),
('PT Maju Jaya','081234567802','Sidoarjo'),
('UD Berkah','081234567803','Bangkalan'),
('CV Sentosa','081234567804','Gresik'),
('PT Niaga Abadi','081234567805','Madura');

INSERT INTO pelanggan (id,nama,jenis_kelamin,telp,alamat) VALUES
('PLG001','Andi Saputra','L','081300000001','Bangkalan'),
('PLG002','Bunga Lestari','P','081300000002','Surabaya'),
('PLG003','Citra Amelia','P','081300000003','Sampang'),
('PLG004','Dimas Pratama','L','081300000004','Pamekasan'),
('PLG005','Eka Putri','P','081300000005','Sumenep');

INSERT INTO `user` (username,password,nama,alamat,hp,level) VALUES
('admin','admin123','Administrator','Bangkalan','081200000001',1),
('kasir1','kasir123','Kasir Satu','Surabaya','081200000002',2),
('kasir2','kasir123','Kasir Dua','Sampang','081200000003',2),
('staff1','staff123','Staff Gudang','Pamekasan','081200000004',3),
('staff2','staff123','Staff Toko','Sumenep','081200000005',3);

INSERT INTO barang (kode_barang,nama_barang,harga,stok,supplier_id) VALUES
('BRG001','Buku Tulis',5000,100,1),
('BRG002','Pulpen',3000,150,2),
('BRG003','Pensil',2500,120,3),
('BRG004','Penghapus',2000,80,4),
('BRG005','Penggaris',4000,70,5),
('BRG006','Spidol',7000,60,1),
('BRG007','Map Plastik',3500,90,2),
('BRG008','Buku Gambar',8000,50,3);

INSERT INTO transaksi (waktu_transaksi,keterangan,total,pelanggan_id) VALUES
('2026-10-01','Pembelian alat tulis',0,'PLG001'),
('2026-10-02','Pembelian perlengkapan sekolah',0,'PLG002'),
('2026-10-03','Pembelian kantor',0,'PLG003'),
('2026-10-04','Pembelian alat tulis',0,'PLG004'),
('2026-10-05','Pembelian buku',0,'PLG005'),
('2026-10-06','Pembelian perlengkapan',0,'PLG001'),
('2026-10-07','Pembelian alat tulis',0,'PLG002'),
('2026-10-08','Pembelian kantor',0,'PLG003'),
('2026-10-09','Pembelian buku dan alat tulis',0,'PLG004'),
('2026-10-10','Pembelian perlengkapan sekolah',0,'PLG005');

INSERT INTO transaksi_detail (transaksi_id,barang_id,harga,qty) VALUES
(1,1,5000,2),(1,2,3000,3),
(2,3,2500,4),(2,4,2000,2),
(3,5,4000,3),(3,6,7000,1),
(4,7,3500,5),(4,8,8000,1),
(5,1,5000,3),(5,3,2500,2),
(6,2,3000,4),(6,5,4000,2),
(7,4,2000,3),(7,6,7000,2),
(8,7,3500,2),(8,8,8000,2),
(9,1,5000,1),(9,5,4000,4),
(10,2,3000,5),(10,3,2500,3);

UPDATE transaksi t
SET total = (
    SELECT COALESCE(SUM(td.harga * td.qty),0)
    FROM transaksi_detail td WHERE td.transaksi_id=t.id
);

INSERT INTO pembayaran (waktu_bayar,total,metode,transaksi_id) VALUES
('2026-10-01 10:00:00',19000,'TUNAI',1),
('2026-10-02 11:00:00',14000,'TRANSFER',2),
('2026-10-03 12:00:00',19000,'EDC',3),
('2026-10-04 13:00:00',25500,'TUNAI',4),
('2026-10-05 14:00:00',20000,'TRANSFER',5);
