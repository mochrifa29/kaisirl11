<?php

namespace App\Imports;

use App\Models\Produk as ModelsProduk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class Produk implements ToCollection,WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $value) {
            $kode = ModelsProduk::where('kode',$value[1])->first();
            if (!$kode) {
                $produk = new ModelsProduk();
                $produk->kode = $value[1];
                $produk->nama = $value[2];
                $produk->harga = $value[3];
                $produk->stok = $value[4];
                $produk->save();
            }
        }
    }
}
