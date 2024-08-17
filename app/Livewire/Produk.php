<?php

namespace App\Livewire;

use App\Imports\Produk as ImportsProduk;
use App\Models\Produk as ModelsProduk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Produk extends Component
{
    use WithFileUploads;
    public $pilihanMenu='lihat';
    public $nama='';
    public $kode='';
    public $harga='';
    public $stok='';
    public $fileExcel;
    public $produk_terpilih;

    public function mount(){
        if (Auth::user()->peran != 'admin') {
            abort(403);
        }
    }

    public function importExcel(){
        Excel::import(new ImportsProduk,$this->fileExcel);
        $this->reset();
    }

    public function simpanEdit(){
        $this->validate([
            'nama' => 'required',
            'kode' => 'required|unique:produks,kode,'.$this->produk_terpilih->id,
            'harga' => 'required',
            'stok' => 'required',
        ],[
            'nama.required' => 'Nama Harus Diisi',
            'kode.required' => 'Kode Harus Diisi',
            'kode.unique' => 'Kode telah digunakan',
            'harga.required' => 'Harga Harus Diisi',
            'stok.required' => 'Stok Harus Diisi',
        ]);

        $simpan = $this->produk_terpilih;
        $simpan->nama = $this->nama;
        $simpan->kode = $this->kode;
        $simpan->harga = $this->harga;
        $simpan->stok = $this->stok;
        $simpan->save();

        $this->reset(['nama','kode','harga','stok','produk_terpilih']);
        $this->pilihanMenu= 'lihat';
    }

    public function Pilih_edit($id){
        $this->produk_terpilih = ModelsProduk::findOrFail($id);
        $this->nama = $this->produk_terpilih->nama;
        $this->kode = $this->produk_terpilih->kode;
        $this->harga = $this->produk_terpilih->harga;
        $this->stok = $this->produk_terpilih->stok;
        $this->pilihanMenu = 'edit';
    }

    public function Pilih_hapus($id){
        $this->produk_terpilih = ModelsProduk::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function batal(){
        $this->reset();
    }

    public function hapus(){
        $this->produk_terpilih->delete();
        $this->pilihanMenu= 'lihat';
    }

    public function simpan(){
        $this->validate([
            'nama' => 'required',
            'kode' => 'required|unique:produks,kode',
            'harga' => 'required',
            'stok' => 'required'
        ],[
            'nama.required' => 'Nama Harus Diisi',
            'kode.required' => 'kode Harus Diisi',
            'kode.unique' => 'kode telah digunakan',
            'harga.required' => 'harga Harus Diisi',
            'stok.required' => 'stok Harus Diisi'
        ]);

        $simpan = new ModelsProduk();
        $simpan->nama = $this->nama;
        $simpan->kode = $this->kode;
        $simpan->harga = $this->harga;
        $simpan->stok = $this->stok;
        $simpan->save();

        $this->reset(['nama','kode','harga','stok']);
        $this->pilihanMenu= 'lihat';
    }


    public function pilihMenu($menu){
        $this->pilihanMenu = $menu;
    }


    public function render()
    {
        return view('livewire.produk')->with([
            'produk' => ModelsProduk::all()
        ]);
    }
}
