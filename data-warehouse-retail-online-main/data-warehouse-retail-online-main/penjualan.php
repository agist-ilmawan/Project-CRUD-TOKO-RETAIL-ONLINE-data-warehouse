<?php
include 'config.php';

$edit = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM fact_penjualan WHERE id_penjualan='$id'");
    $edit = mysqli_fetch_assoc($result);
}

if (isset($_POST['simpan'])) {
    $id_produk = $_POST['id_produk'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_waktu = $_POST['id_waktu'];
    $jumlah = $_POST['jumlah'];

    $produk = mysqli_query($conn, "SELECT harga FROM dim_produk WHERE id_produk='$id_produk'");
    $row_produk = mysqli_fetch_assoc($produk);

    $harga_satuan = $row_produk['harga'];
    $total_harga = $jumlah * $harga_satuan;

    mysqli_query($conn, "INSERT INTO fact_penjualan 
        (id_produk, id_pelanggan, id_waktu, jumlah, harga_satuan, total_harga)
        VALUES 
        ('$id_produk', '$id_pelanggan', '$id_waktu', '$jumlah', '$harga_satuan', '$total_harga')");

    header("Location: penjualan.php");
}

if (isset($_POST['update'])) {
    $id_penjualan = $_POST['id_penjualan'];
    $id_produk = $_POST['id_produk'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_waktu = $_POST['id_waktu'];
    $jumlah = $_POST['jumlah'];

    $produk = mysqli_query($conn, "SELECT harga FROM dim_produk WHERE id_produk='$id_produk'");
    $row_produk = mysqli_fetch_assoc($produk);

    $harga_satuan = $row_produk['harga'];
    $total_harga = $jumlah * $harga_satuan;

    mysqli_query($conn, "UPDATE fact_penjualan SET
        id_produk='$id_produk',
        id_pelanggan='$id_pelanggan',
        id_waktu='$id_waktu',
        jumlah='$jumlah',
        harga_satuan='$harga_satuan',
        total_harga='$total_harga'
        WHERE id_penjualan='$id_penjualan'");

    header("Location: penjualan.php");
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM fact_penjualan WHERE id_penjualan='$id'");
    header("Location: penjualan.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Penjualan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

<h2>CRUD Tabel Fakta Penjualan</h2>

<a href="index.php" class="back-link">← Kembali ke Menu</a>
<br><br>

<form method="POST">
    <?php if ($edit) { ?>
        <input type="hidden" name="id_penjualan" value="<?= $edit['id_penjualan']; ?>">
    <?php } ?>

    <label>Produk</label><br>
    <select name="id_produk" required>
        <?php
        $produk = mysqli_query($conn, "SELECT * FROM dim_produk");
        while ($p = mysqli_fetch_assoc($produk)) {
        ?>
            <option value="<?= $p['id_produk']; ?>" 
                <?= ($edit && $edit['id_produk'] == $p['id_produk']) ? 'selected' : ''; ?>>
                <?= $p['nama_produk']; ?> - Rp <?= number_format($p['harga'], 0, ',', '.'); ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Pelanggan</label><br>
    <select name="id_pelanggan" required>
        <?php
        $pelanggan = mysqli_query($conn, "SELECT * FROM dim_pelanggan");
        while ($pl = mysqli_fetch_assoc($pelanggan)) {
        ?>
            <option value="<?= $pl['id_pelanggan']; ?>"
                <?= ($edit && $edit['id_pelanggan'] == $pl['id_pelanggan']) ? 'selected' : ''; ?>>
                <?= $pl['nama_pelanggan']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Waktu Transaksi</label><br>
    <select name="id_waktu" required>
        <?php
        $waktu = mysqli_query($conn, "SELECT * FROM dim_waktu ORDER BY tanggal ASC");
        while ($w = mysqli_fetch_assoc($waktu)) {
        ?>
            <option value="<?= $w['id_waktu']; ?>"
                <?= ($edit && $edit['id_waktu'] == $w['id_waktu']) ? 'selected' : ''; ?>>
                <?= $w['tanggal']; ?> - <?= $w['bulan_nama']; ?> <?= $w['tahun']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Jumlah</label><br>
    <input type="number" name="jumlah" required value="<?= $edit ? $edit['jumlah'] : ''; ?>"><br><br>

    <?php if ($edit) { ?>
        <button type="submit" name="update">Update Penjualan</button>
        <a href="penjualan.php">Batal</a>
    <?php } else { ?>
        <button type="submit" name="simpan">Simpan Penjualan</button>
    <?php } ?>
</form>

<br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Produk</th>
        <th>Pelanggan</th>
        <th>Tanggal</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Total Harga</th>
        <th>Aksi</th>
    </tr>

    <?php
    $data = mysqli_query($conn, "
        SELECT 
            f.id_penjualan,
            p.nama_produk,
            pl.nama_pelanggan,
            w.tanggal,
            f.jumlah,
            f.harga_satuan,
            f.total_harga
        FROM fact_penjualan f
        JOIN dim_produk p ON f.id_produk = p.id_produk
        JOIN dim_pelanggan pl ON f.id_pelanggan = pl.id_pelanggan
        JOIN dim_waktu w ON f.id_waktu = w.id_waktu
        ORDER BY f.id_penjualan ASC
    ");

    while ($row = mysqli_fetch_assoc($data)) {
    ?>
    <tr>
        <td><?= $row['id_penjualan']; ?></td>
        <td><?= $row['nama_produk']; ?></td>
        <td><?= $row['nama_pelanggan']; ?></td>
        <td><?= $row['tanggal']; ?></td>
        <td><?= $row['jumlah']; ?></td>
        <td>Rp <?= number_format($row['harga_satuan'], 0, ',', '.'); ?></td>
        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
        <td>
            <a href="penjualan.php?edit=<?= $row['id_penjualan']; ?>">Edit</a> |
            <a href="penjualan.php?hapus=<?= $row['id_penjualan']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>

</div>

</body>
</html>