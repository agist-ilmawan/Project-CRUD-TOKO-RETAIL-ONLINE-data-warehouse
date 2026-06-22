<?php
include 'config.php';

$edit = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM dim_produk WHERE id_produk='$id'");
    $edit = mysqli_fetch_assoc($result);
}

if (isset($_POST['simpan'])) {
    $kode_produk = $_POST['kode_produk'];
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "INSERT INTO dim_produk 
        (kode_produk, nama_produk, kategori, harga) 
        VALUES 
        ('$kode_produk', '$nama_produk', '$kategori', '$harga')");

    header("Location: produk.php");
}

if (isset($_POST['update'])) {
    $id_produk = $_POST['id_produk'];
    $kode_produk = $_POST['kode_produk'];
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "UPDATE dim_produk SET 
        kode_produk='$kode_produk',
        nama_produk='$nama_produk',
        kategori='$kategori',
        harga='$harga'
        WHERE id_produk='$id_produk'");

    header("Location: produk.php");
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM dim_produk WHERE id_produk='$id'");
    header("Location: produk.php");
}
?>

<head>
    <title>CRUD Produk</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

<h2>CRUD Dimensi Produk</h2>

<a href="index.php" class="back-link">← Kembali ke Menu</a>
<br><br>

<form method="POST">
    <?php if ($edit) { ?>
        <input type="hidden" name="id_produk" value="<?= $edit['id_produk']; ?>">
    <?php } ?>

    <label>Kode Produk</label><br>
    <input type="text" name="kode_produk" required value="<?= $edit ? $edit['kode_produk'] : ''; ?>"><br><br>

    <label>Nama Produk</label><br>
    <input type="text" name="nama_produk" required value="<?= $edit ? $edit['nama_produk'] : ''; ?>"><br><br>

    <label>Kategori</label><br>
    <select name="kategori" required>
        <option value="Elektronik" <?= ($edit && $edit['kategori'] == 'Elektronik') ? 'selected' : ''; ?>>Elektronik</option>
        <option value="Aksesoris" <?= ($edit && $edit['kategori'] == 'Aksesoris') ? 'selected' : ''; ?>>Aksesoris</option>
        <option value="Pakaian" <?= ($edit && $edit['kategori'] == 'Pakaian') ? 'selected' : ''; ?>>Pakaian</option>
    </select><br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" required value="<?= $edit ? $edit['harga'] : ''; ?>"><br><br>

    <?php if ($edit) { ?>
        <button type="submit" name="update">Update Produk</button>
        <a href="produk.php">Batal</a>
    <?php } else { ?>
        <button type="submit" name="simpan">Simpan Produk</button>
    <?php } ?>
</form>

<br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>

    <?php
    $data = mysqli_query($conn, "SELECT * FROM dim_produk");
    while ($row = mysqli_fetch_assoc($data)) {
    ?>
    <tr>
        <td><?= $row['id_produk']; ?></td>
        <td><?= $row['kode_produk']; ?></td>
        <td><?= $row['nama_produk']; ?></td>
        <td><?= $row['kategori']; ?></td>
        <td><?= $row['harga']; ?></td>
        <td>
            <a href="produk.php?edit=<?= $row['id_produk']; ?>">Edit</a> |
            <a href="produk.php?hapus=<?= $row['id_produk']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>

</div>

</body>
</html>