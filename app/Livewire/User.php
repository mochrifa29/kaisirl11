<?php

namespace App\Livewire;

use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class User extends Component
{
    public $pilihanMenu='lihat';
    public $nama='';
    public $email='';
    public $peran='';
    public $password='';
    public $pengguna_terpilih;

    public function mount(){
        if (Auth::user()->peran != 'admin') {
            abort(403);
        }
    }
    public function simpanEdit(){
        $this->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->pengguna_terpilih->id,
            'peran' => 'required',
        ],[
            'nama.required' => 'Nama Harus Diisi',
            'email.required' => 'Email Harus Diisi',
            'email.unique' => 'Email telah digunakan',
            'peran.required' => 'Peran Harus Diisi',
        ]);

        $simpan = $this->pengguna_terpilih;
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        $simpan->peran = $this->peran;
        if ($this->password) {
            $simpan->password = bcrypt($this->password);
        }
      
        $simpan->save();

        $this->reset(['nama','email','peran','password','pengguna_terpilih']);
        $this->pilihanMenu= 'lihat';
    }

    public function Pilih_edit($id){
        $this->pengguna_terpilih = ModelsUser::findOrFail($id);
        $this->nama = $this->pengguna_terpilih->name;
        $this->email = $this->pengguna_terpilih->email;
        $this->peran = $this->pengguna_terpilih->peran;
        $this->pilihanMenu = 'edit';
    }

    public function Pilih_hapus($id){
        $this->pengguna_terpilih = ModelsUser::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function batal(){
        $this->reset();
    }

    public function hapus(){
        $this->pengguna_terpilih->delete();
        $this->pilihanMenu= 'lihat';
    }

    public function simpan(){
        $this->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'peran' => 'required',
            'password' => 'required'
        ],[
            'nama.required' => 'Nama Harus Diisi',
            'email.required' => 'Email Harus Diisi',
            'email.unique' => 'Email telah digunakan',
            'peran.required' => 'Peran Harus Diisi',
            'password.required' => 'Password Harus Diisi'
        ]);

        $simpan = new ModelsUser();
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        $simpan->peran = $this->peran;
        $simpan->password = bcrypt($this->password);
        $simpan->save();

        $this->reset(['nama','email','peran','password']);
        $this->pilihanMenu= 'lihat';
    }


    public function pilihMenu($menu){
        $this->pilihanMenu = $menu;
    }

    public function render()
    {
        return view('livewire.user')->with([
            'pengguna' => ModelsUser::all()
        ]);
    }


}
