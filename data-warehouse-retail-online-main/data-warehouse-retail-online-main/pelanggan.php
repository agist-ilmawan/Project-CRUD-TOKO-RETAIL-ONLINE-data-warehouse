<?php
include 'config.php';

$edit = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM dim_pelanggan WHERE id_pelanggan='$id'");
    $edit = mysqli_fetch_assoc($result);
}

if (isset($_POST['simpan'])) {
    $kode_pelanggan = $_POST['kode_pelanggan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $kota = $_POST['kota'];

    mysqli_query($conn, "INSERT INTO dim_pelanggan 
        (kode_pelanggan, nama_pelanggan, jenis_kelamin, kota) 
        VALUES 
        ('$kode_pelanggan', '$nama_pelanggan', '$jenis_kelamin', '$kota')");

    header("Location: pelanggan.php");
}

if (isset($_POST['update'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $kode_pelanggan = $_POST['kode_pelanggan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $kota = $_POST['kota'];

    mysqli_query($conn, "UPDATE dim_pelanggan SET 
        kode_pelanggan='$kode_pelanggan',
        nama_pelanggan='$nama_pelanggan',
        jenis_kelamin='$jenis_kelamin',
        kota='$kota'
        WHERE id_pelanggan='$id_pelanggan'");

    header("Location: pelanggan.php");
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM dim_pelanggan WHERE id_pelanggan='$id'");
    header("Location: pelanggan.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Pelanggan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

    <h2>CRUD Dimensi Pelanggan</h2>

<a href="index.php" class="back-link">← Kembali ke Menu</a>
<br><br>

<form method="POST">
    <?php if ($edit) { ?>
        <input type="hidden" name="id_pelanggan" value="<?= $edit['id_pelanggan']; ?>">
    <?php } ?>

    <label>Kode Pelanggan</label><br>
    <input type="text" name="kode_pelanggan" required value="<?= $edit ? $edit['kode_pelanggan'] : ''; ?>"><br><br>

    <label>Nama Pelanggan</label><br>
    <input type="text" name="nama_pelanggan" required value="<?= $edit ? $edit['nama_pelanggan'] : ''; ?>"><br><br>

    <label>Jenis Kelamin</label><br>
    <select name="jenis_kelamin" required>
        <option value="L" <?= ($edit && $edit['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
        <option value="P" <?= ($edit && $edit['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
    </select><br><br>

    <label>Kota</label><br>
    <input type="text" name="kota" required value="<?= $edit ? $edit['kota'] : ''; ?>"><br><br>

    <?php if ($edit) { ?>
        <button type="submit" name="update">Update Pelanggan</button>
        <a href="pelanggan.php">Batal</a>
    <?php } else { ?>
        <button type="submit" name="simpan">Simpan Pelanggan</button>
    <?php } ?>
</form>

<br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Kode Pelanggan</th>
        <th>Nama Pelanggan</th>
        <th>Jenis Kelamin</th>
        <th>Kota</th>
        <th>Aksi</th>
    </tr>

    <?php
    $data = mysqli_query($conn, "SELECT * FROM dim_pelanggan");
    while ($row = mysqli_fetch_assoc($data)) {
    ?>
    <tr>
        <td><?= $row['id_pelanggan']; ?></td>
        <td><?= $row['kode_pelanggan']; ?></td>
        <td><?= $row['nama_pelanggan']; ?></td>
        <td><?= $row['jenis_kelamin']; ?></td>
        <td><?= $row['kota']; ?></td>
        <td>
            <a href="pelanggan.php?edit=<?= $row['id_pelanggan']; ?>">Edit</a> |
            <a href="pelanggan.php?hapus=<?= $row['id_pelanggan']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>

</div>

</body>
</html>