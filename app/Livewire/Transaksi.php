<?php

namespace App\Livewire;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi as ModelsTransaksi;
use Livewire\Component;

class Transaksi extends Component
{
    public $kode,$total,$bayar,$kembalian,$totalBelanja;
    public $transaksi;

    public function transaksi_baru(){
        $this->reset();
        $this->transaksi = new ModelsTransaksi();
        $this->transaksi->no_invoice = 'INV/'.date('YmdHis');
        $this->transaksi->total = 0;
        $this->transaksi->status = 'pending';
        $this->transaksi->save();
    }

    public function batal_transaksi(){
        if ($this->transaksi) {
            $detail_transaksi = DetailTransaksi::where('transaksi_id',$this->transaksi->id)->get();
            foreach ($detail_transaksi as $key => $value) {
                $value->delete();
            }
            $this->transaksi->delete();
        }
        $this->reset();
        
    }

    public function updatedKode(){
        $produk = Produk::where('kode',$this->kode)->first();
        if ($produk && $produk->stok > 0) {
            $detail_transaksi = DetailTransaksi::firstOrNew([
                'transaksi_id' => $this->transaksi->id,
                'produk_id' => $produk->id
            ],[
                'jumlah' => 0
            ]);

            $detail_transaksi->jumlah +=1;
            $detail_transaksi->save();
            $this->reset(['kode']);
        }
    }

    public function render()
    {
        if ($this->transaksi) {
            $semuaProduk = DetailTransaksi::where('transaksi_id',$this->transaksi->id)->get();
        }else{
            $semuaProduk = [];
        }
        return view('livewire.transaksi')->with([
            'semuaProduk' => $semuaProduk
        ]);
       
    }
}
