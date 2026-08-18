<?php

class Produk
{
    private $nama;
    private $harga;
    private $stok;

    public function __construct($nama, $harga, $stok)
    {
        $this->nama = $nama;
        $this->harga = $harga;
        $this->stok = $stok;
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function getHarga()
    {
        return $this->harga;
    }

    public function getStok()
    {
        return $this->stok;
    }

    public function kurangiStok($jumlah)
    {
        $this->stok -= $jumlah;
    }
}

?>


