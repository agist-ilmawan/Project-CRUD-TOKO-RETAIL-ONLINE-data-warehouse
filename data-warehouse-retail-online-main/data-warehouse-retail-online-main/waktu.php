<?php
include 'config.php';

if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];

    $tahun = date('Y', strtotime($tanggal));
    $bulan = date('n', strtotime($tanggal));

    $nama_bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $bulan_nama = $nama_bulan[$bulan];
    $kuartal = ceil($bulan / 3);

    mysqli_query($conn, "INSERT INTO dim_waktu 
        (tanggal, tahun, bulan, bulan_nama, kuartal) 
        VALUES 
        ('$tanggal', '$tahun', '$bulan', '$bulan_nama', '$kuartal')");

    header("Location: waktu.php");
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM dim_waktu WHERE id_waktu='$id'");
    header("Location: waktu.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Waktu</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

<h2>CRUD Dimensi Waktu</h2>

<a href="index.php" class="back-link">← Kembali ke Menu</a>
<br><br>

<form method="POST">
    <label>Tanggal</label><br>
    <input type="date" name="tanggal" required><br><br>

    <button type="submit" name="simpan">Simpan Data Waktu</button>
</form>

<br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Tahun</th>
        <th>Bulan</th>
        <th>Nama Bulan</th>
        <th>Kuartal</th>
        <th>Aksi</th>
    </tr>

    <?php
    $data = mysqli_query($conn, "SELECT * FROM dim_waktu ORDER BY tanggal ASC");
    while ($row = mysqli_fetch_assoc($data)) {
    ?>
    <tr>
        <td><?= $row['id_waktu']; ?></td>
        <td><?= $row['tanggal']; ?></td>
        <td><?= $row['tahun']; ?></td>
        <td><?= $row['bulan']; ?></td>
        <td><?= $row['bulan_nama']; ?></td>
        <td><?= $row['kuartal']; ?></td>
        <td>
            <a href="waktu.php?hapus=<?= $row['id_waktu']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>

</div>

</body>
</html>