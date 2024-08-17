<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Livewire\Component;

class Laporan extends Component
{
    public function render()
    {
        $transaksi = Transaksi::where('status','selesai')->get();
        return view('livewire.laporan')->with([
            'laporan' => $transaksi
        ]);
    }
}
