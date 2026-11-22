<?php
require_once "koneksi.php";
require_once "auth.php";
wajib_level([1, 2]);

$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

$rekap = [];
$labels = [];
$data_total = [];
$total_pendapatan = 0;
$total_pelanggan = 0;
$pesan = '';

if ($tanggal_mulai !== '' && $tanggal_selesai !== '') {
    if ($tanggal_mulai > $tanggal_selesai) {
        $pesan = "Tanggal mulai tidak boleh lebih besar dari tanggal selesai.";
    } else {
        $sql = "SELECT DATE(waktu_transaksi) AS tanggal,
                       SUM(total) AS total_harian
                FROM transaksi
                WHERE DATE(waktu_transaksi) BETWEEN ? AND ?
                GROUP BY DATE(waktu_transaksi)
                ORDER BY tanggal ASC";

        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $tanggal_mulai, $tanggal_selesai);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);

        while ($baris = mysqli_fetch_assoc($hasil)) {
            $rekap[] = $baris;
            $labels[] = $baris['tanggal'];
            $data_total[] = (float) $baris['total_harian'];
            $total_pendapatan += (float) $baris['total_harian'];
        }
        mysqli_stmt_close($stmt);

        $sql_pelanggan = "SELECT COUNT(DISTINCT pelanggan_id) AS jumlah
                          FROM transaksi
                          WHERE DATE(waktu_transaksi) BETWEEN ? AND ?";

        $stmt_pelanggan = mysqli_prepare($koneksi, $sql_pelanggan);
        mysqli_stmt_bind_param($stmt_pelanggan, "ss", $tanggal_mulai, $tanggal_selesai);
        mysqli_stmt_execute($stmt_pelanggan);
        $hasil_pelanggan = mysqli_stmt_get_result($stmt_pelanggan);
        $data_pelanggan = mysqli_fetch_assoc($hasil_pelanggan);
        $total_pelanggan = (int) ($data_pelanggan['jumlah'] ?? 0);
        mysqli_stmt_close($stmt_pelanggan);
    }
}

function rupiah($angka) {
    return "Rp " . number_format((float) $angka, 0, ',', '.');
}

$judul = 'Laporan';
$extra_head = '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
require "header.php";
?>
    <style>
        h1.jdl, h2.jdl { text-align: center; }
        .filter { margin-bottom: 25px; padding: 15px; background: #f2f2f2; }
        .filter input, .filter button { margin: 5px; padding: 7px; }
        .aksi { margin: 15px 0; text-align: center; }
        .aksi button, .filter button { padding: 8px 14px; cursor: pointer; }
        .aksi a { margin-left: 8px; }
        .grafik { width: 100%; max-width: 850px; height: 350px; margin: 20px auto; }
        table.lap { border-collapse: collapse; width: 100%; margin-top: 15px; }
        table.lap th, table.lap td { border: 1px solid #999; padding: 9px; text-align: left; }
        table.lap th { background: #e5e5e5; }
        .ringkasan { display: flex; gap: 15px; margin-top: 20px; }
        .card { flex: 1; border: 1px solid #aaa; padding: 15px; text-align: center; }
        .pesan { text-align: center; margin: 20px; }
        @media print {
            .no-print { display: none !important; }
            .grafik { max-width: 100%; }
        }
    </style>

    <div class="no-print filter">
        <h1 class="jdl">Filter Laporan Penjualan</h1>
        <form method="GET" action="">
            <label for="tanggal_mulai">Tanggal Mulai:</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                   value="<?= htmlspecialchars($tanggal_mulai); ?>" required>

            <label for="tanggal_selesai">Tanggal Selesai:</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                   value="<?= htmlspecialchars($tanggal_selesai); ?>" required>

            <button type="submit">Tampilkan</button>
        </form>
    </div>

    <?php if ($pesan !== ''): ?>
        <p class="pesan"><?= htmlspecialchars($pesan); ?></p>
    <?php elseif ($tanggal_mulai !== '' && $tanggal_selesai !== ''): ?>
        <h1 class="jdl">Laporan Penjualan</h1>
        <p style="text-align:center;">
            Periode <?= htmlspecialchars($tanggal_mulai); ?>
            sampai <?= htmlspecialchars($tanggal_selesai); ?>
        </p>

        <div class="no-print aksi">
            <button type="button" onclick="window.print()">Cetak</button>
            <a href="export_excel.php?tanggal_mulai=<?= urlencode($tanggal_mulai); ?>&tanggal_selesai=<?= urlencode($tanggal_selesai); ?>">
                <button type="button">Ekspor Excel</button>
            </a>
        </div>

        <?php if (count($rekap) > 0): ?>
            <h2 class="jdl">Grafik Penjualan Harian</h2>
            <div class="grafik">
                <canvas id="grafikPenjualan"></canvas>
            </div>

            <h2 class="jdl">Rekapitulasi Penjualan</h2>
            <table class="lap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Total Pendapatan</th>
                        <th>Tanggal Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($rekap as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= rupiah($row['total_harian']); ?></td>
                            <td><?= htmlspecialchars($row['tanggal']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="ringkasan">
                <div class="card">
                    <strong>Jumlah Pelanggan Unik</strong>
                    <p><?= $total_pelanggan; ?> orang</p>
                </div>
                <div class="card">
                    <strong>Total Pendapatan Keseluruhan</strong>
                    <p><?= rupiah($total_pendapatan); ?></p>
                </div>
            </div>

            <script>
                const tanggal = <?= json_encode($labels); ?>;
                const pendapatan = <?= json_encode($data_total); ?>;

                new Chart(document.getElementById('grafikPenjualan'), {
                    type: 'bar',
                    data: {
                        labels: tanggal,
                        datasets: [{
                            label: 'Total Pendapatan',
                            data: pendapatan
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { title: { display: true, text: 'Tanggal Transaksi' } },
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Total Pendapatan (Rupiah)' }
                            }
                        }
                    }
                });
            </script>
        <?php else: ?>
            <p class="pesan">Tidak ada transaksi pada rentang tanggal tersebut.</p>
        <?php endif; ?>
    <?php else: ?>
        <p class="pesan">Silakan pilih tanggal mulai dan tanggal selesai untuk menampilkan laporan.</p>
    <?php endif; ?>
<?php require "footer.php"; ?>
