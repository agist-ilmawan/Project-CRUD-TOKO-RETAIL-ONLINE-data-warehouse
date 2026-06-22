<?php
include 'config.php';

$q1 = mysqli_query($conn, "
    SELECT 
        p.nama_produk,
        SUM(f.jumlah) AS total_terjual,
        SUM(f.total_harga) AS total_pendapatan
    FROM fact_penjualan f
    JOIN dim_produk p ON f.id_produk = p.id_produk
    GROUP BY p.nama_produk
    ORDER BY total_pendapatan DESC
");

$q2 = mysqli_query($conn, "
    SELECT 
        w.bulan,
        w.bulan_nama,
        SUM(f.total_harga) AS total_pendapatan
    FROM fact_penjualan f
    JOIN dim_waktu w ON f.id_waktu = w.id_waktu
    GROUP BY w.bulan, w.bulan_nama
    ORDER BY w.bulan
");

$q3 = mysqli_query($conn, "
    SELECT 
        pl.nama_pelanggan,
        SUM(f.total_harga) AS total_belanja,
        COUNT(f.id_penjualan) AS jumlah_transaksi
    FROM fact_penjualan f
    JOIN dim_pelanggan pl ON f.id_pelanggan = pl.id_pelanggan
    GROUP BY pl.nama_pelanggan
    ORDER BY total_belanja DESC
");

$total_pendapatan = mysqli_query($conn, "SELECT SUM(total_harga) AS total FROM fact_penjualan");
$total_pendapatan = mysqli_fetch_assoc($total_pendapatan)['total'];

$total_transaksi = mysqli_query($conn, "SELECT COUNT(*) AS total FROM fact_penjualan");
$total_transaksi = mysqli_fetch_assoc($total_transaksi)['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Data Warehouse</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

<h2>Dashboard Data Warehouse</h2>

<a href="index.php" class="back-link">← Kembali ke Menu</a>
<br><br>

<h3>Ringkasan Penjualan</h3>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Total Pendapatan</th>
        <th>Total Transaksi</th>
    </tr>
    <tr>
        <td>Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></td>
        <td><?= $total_transaksi; ?> Transaksi</td>
    </tr>
</table>

<br>

<h3>1. Total Penjualan per Produk</h3>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Nama Produk</th>
        <th>Total Terjual</th>
        <th>Total Pendapatan</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($q1)) { ?>
    <tr>
        <td><?= $row['nama_produk']; ?></td>
        <td><?= $row['total_terjual']; ?></td>
        <td>Rp <?= number_format($row['total_pendapatan'], 0, ',', '.'); ?></td>
    </tr>
    <?php } ?>
</table>

<br>

<h3>2. Tren Penjualan per Bulan</h3>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Bulan</th>
        <th>Total Pendapatan</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($q2)) { ?>
    <tr>
        <td><?= $row['bulan_nama']; ?></td>
        <td>Rp <?= number_format($row['total_pendapatan'], 0, ',', '.'); ?></td>
    </tr>
    <?php } ?>
</table>

<br>

<h3>3. Pelanggan dengan Belanja Tertinggi</h3>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Nama Pelanggan</th>
        <th>Total Belanja</th>
        <th>Jumlah Transaksi</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($q3)) { ?>
    <tr>
        <td><?= $row['nama_pelanggan']; ?></td>
        <td>Rp <?= number_format($row['total_belanja'], 0, ',', '.'); ?></td>
        <td><?= $row['jumlah_transaksi']; ?></td>
    </tr>
    <?php } ?>
</table>

</div>

</body>
</html>