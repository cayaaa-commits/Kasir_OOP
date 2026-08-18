<?php

class Transaksi
{
    private $items = [];
    private $total = 0;

    public function tambahProduk(Produk $produk, $jumlah)
    {
        if ($jumlah <= 0) {
            return "Jumlah harus lebih dari 0";
        }

        if ($jumlah > $produk->getStok()) {
            return "Stok tidak mencukupi";
        }

        $this->items[] = [
            "produk" => $produk,
            "jumlah" => $jumlah
        ];

        return true;
    }

    public function hitungTotal()
    {
        $this->total = 0;

        foreach ($this->items as $item) {
            $this->total += $item["produk"]->getHarga() * $item["jumlah"];
        }

        return $this->total;
    }

    public function prosesBayar($uangBayar)
    {
        if ($uangBayar < $this->total) {
            return "Uang pembayaran kurang";
        }

        return $uangBayar - $this->total;
    }

    public function getItems()
    {
        return $this->items;
    }
}
?>
