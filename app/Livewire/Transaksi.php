<?php

namespace App\Livewire;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi as ModelsTransaksi;
use Livewire\Component;

class Transaksi extends Component
{
    public $kode,$total,$kembalian,$totalBelanja;
    public $bayar=0;
    public $transaksi;

    public function hapusProduk($id){
        $detail_transaksi = DetailTransaksi::find($id);
        if ($detail_transaksi) {
            $produk = Produk::find($detail_transaksi->produk_id);
            $produk->stok += $detail_transaksi->jumlah;
            $produk->save();
        }
        $detail_transaksi->delete();
    }

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
                $produk = Produk::find($value->produk_id);
                $produk->stok += $value->jumlah;
                $produk->save();
                $value->delete();
            }
            $this->transaksi->delete();
        }
        $this->reset();
        
    }

    public function transaksi_selesai() {
        $this->transaksi->total = $this->totalBelanja;
        $this->transaksi->status = 'selesai';
        $this->transaksi->save();
        $this->reset();
    }

    public function updatedBayar(){
        if ($this->bayar > 0) {
             $this->kembalian = $this->bayar - $this->totalBelanja;
        }else{
            $this->kembalian = 0 - $this->totalBelanja;
        }
       
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
            $produk->stok -= 1;
            $produk->save();
            $this->reset('kode');
        }
    }

    public function render()
    {
        if ($this->transaksi) {
            $semuaProduk = DetailTransaksi::where('transaksi_id',$this->transaksi->id)->get();
            $this->totalBelanja = $semuaProduk->sum(function ($detail) {
                return $detail->produk->harga * $detail->jumlah;
            });
        }else{
            $cek_pending = DetailTransaksi::whereHas('transaksi',function($query) {
                $query->where('status','pending');

            })->latest()->first();
            if ($cek_pending) {
                $this->transaksi = $cek_pending->transaksi;
                $semuaProduk = $cek_pending->transaksi->detail_transaksi;
            }else{
                $semuaProduk = [];
            }
           
        }

        return view('livewire.transaksi')->with([
            'semuaProduk' => $semuaProduk
        ]);
       
    }
}
