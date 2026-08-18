<?php

require_once "Produk.php";
require_once "Transaksi.php";

$produk1 = new Produk("Indomie", 3000, 10);
$produk2 = new Produk("Teh Botol", 5000, 8);
$produk3 = new Produk("Roti", 7000, 5);

$produk = [
    1 => $produk1,
    2 => $produk2,
    3 => $produk3
];

$pesan = "";
$hasilTransaksi = false;
$total = 0;
$kembalian = 0;
$uangBayar = 0;

if (isset($_POST["beli"])) {

    $pilihan = $_POST["produk"];
    $jumlah = $_POST["jumlah"];
    $uangBayar = $_POST["uang_bayar"];

    $transaksi = new Transaksi();

    $hasil = $transaksi->tambahProduk($produk[$pilihan], $jumlah);

    if ($hasil === true) {

        $total = $transaksi->hitungTotal();

        $hasilBayar = $transaksi->prosesBayar($uangBayar);

        if (is_numeric($hasilBayar)) {

            $produk[$pilihan]->kurangiStok($jumlah);

            $kembalian = $hasilBayar;
            $hasilTransaksi = true;

        } else {
            $pesan = $hasilBayar;
        }

    } else {
        $pesan = $hasil;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kasir OOP</title>
</head>

<body>

<h1>Kasir OOP</h1>

<h2>Daftar Produk</h2>

<table border="1">
    <tr>
        <th>Produk</th>
        <th>Harga</th>
        <th>Stok</th>
    </tr>

    <?php foreach ($produk as $id => $item) { ?>
        <tr>
            <td><?php echo $item->getNama(); ?></td>
            <td>Rp<?php echo number_format($item->getHarga(), 0, ',', '.'); ?></td>
            <td><?php echo $item->getStok(); ?></td>
        </tr>
    <?php } ?>

</table>

<h2>Form Pembelian</h2>

<form method="POST">

    <label>Pilih Produk:</label>

    <select name="produk">

        <?php foreach ($produk as $id => $item) { ?>

            <option value="<?php echo $id; ?>">
                <?php echo $item->getNama(); ?>
            </option>

        <?php } ?>

    </select>

    <br><br>

    <label>Jumlah Beli:</label>
    <input type="number" name="jumlah" min="1" required>

    <br><br>

    <label>Uang Bayar:</label>
    <input type="number" name="uang_bayar" min="0" required>

    <br><br>

    <button type="submit" name="beli">Beli</button>

</form>

<?php if ($pesan != "") { ?>

    <h3><?php echo $pesan; ?></h3>

<?php } ?>

<?php if ($hasilTransaksi) { ?>

    <h2>Ringkasan Belanja</h2>

    <?php foreach ($transaksi->getItems() as $item) { ?>

        <?php
        $nama = $item["produk"]->getNama();
        $jumlah = $item["jumlah"];
        $harga = $item["produk"]->getHarga();
        $subtotal = $harga * $jumlah;
        ?>

        <p>
            Nama Barang: <?php echo $nama; ?><br>
            Jumlah: <?php echo $jumlah; ?><br>
            Subtotal: Rp<?php echo number_format($subtotal, 0, ',', '.'); ?>
        </p>

    <?php } ?>

    <p>
        <strong>Total Bayar:</strong>
        Rp<?php echo number_format($total, 0, ',', '.'); ?>
    </p>

    <p>
        <strong>Uang Bayar:</strong>
        Rp<?php echo number_format($uangBayar, 0, ',', '.'); ?>
    </p>

    <p>
        <strong>Uang Kembalian:</strong>
        Rp<?php echo number_format($kembalian, 0, ',', '.'); ?>
    </p>

    <h2>Sisa Stok</h2>

    <?php foreach ($produk as $item) { ?>

        <p>
            <?php echo $item->getNama(); ?> :
            <?php echo $item->getStok(); ?>
        </p>

    <?php } ?>

<?php } ?>

</body>
</html>
