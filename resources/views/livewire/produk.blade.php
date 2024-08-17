<div>
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <button wire:click="pilihMenu('lihat')"
                    class="btn {{ $pilihanMenu == 'lihat' ? 'btn-primary' : 'btn-outline-primary' }}">Semua
                    Produk</button>
                <button wire:click="pilihMenu('tambah')"
                    class="btn {{ $pilihanMenu == 'tambah' ? 'btn-primary' : 'btn-outline-primary' }}">Tambah
                    Produk</button>
                <button wire:click="pilihMenu('excel')"
                    class="btn {{ $pilihanMenu == 'tambah' ? 'btn-primary' : 'btn-outline-primary' }}">Import Produk</button>
                <button wire:loading class="btn btn-info">Loading...</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if ($pilihanMenu == 'lihat')
                    <div class="card border-primary">
                        <div class="card-header">
                            Produk
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    @foreach ($produk as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->harga }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>
                                                <button wire:click="Pilih_edit({{ $item->id }})"
                                                    class="btn {{ $pilihanMenu == 'edit' ? 'btn-primary' : 'btn-outline-primary' }}">Edit</button>
                                                <button wire:click="Pilih_hapus({{ $item->id }})"
                                                    class="btn {{ $pilihanMenu == 'hapus' ? 'btn-primary' : 'btn-outline-primary' }}">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif($pilihanMenu == 'tambah')
                    <div class="card border-primary">
                        <div class="card-header">
                            Tambah Produk
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent='simpan'>
                                <div class="mb-3">
                                    <label for="">Nama</label>
                                    <input type="text" wire:model='nama' class="form-control">
                                    @error('nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Kode</label>
                                    <input type="text" wire:model='kode' class="form-control">
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Harga</label>
                                    <input type="text" wire:model='harga' class="form-control">
                                    @error('harga')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Stok</label>
                                    <input type="text" wire:model='stok' class="form-control">
                                    @error('stok')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                @elseif($pilihanMenu == 'edit')
                    <div class="card border-primary">
                        <div class="card-header">
                            Edit Produk
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent='simpanEdit'>
                                <div class="mb-3">
                                    <label for="">Nama</label>
                                    <input type="text" wire:model='nama' class="form-control">
                                    @error('nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Kode</label>
                                    <input type="text" wire:model='kode' class="form-control">
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Harga</label>
                                    <input type="text" wire:model='harga' class="form-control">
                                    @error('harga')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Stok</label>
                                    <input type="text" wire:model='stok' class="form-control">
                                    @error('stok')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                @elseif($pilihanMenu == 'hapus')
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            Hapus Produk
                        </div>
                        <div class="card-body">
                            Anda yakin akan menghapus produk ini ?
                            <p>Nama : {{ $produk_terpilih->nama }}</p>
                            <p>Kode : {{ $produk_terpilih->kode }}</p>
                            <button wire:click='hapus' class="btn btn-danger">Hapus</button>
                            <button wire:click='batal' class="btn btn-secondary">Batal</button>
                        </div>
                    </div>
                @elseif($pilihanMenu == 'excel')
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            Import Produk
                        </div>
                        <div class="card-body">
                            <form wire:submit='importExcel'>
                                <input type="file" class="form-control" wire:model='fileExcel'>
                                <br/>
                                <button type="submit" class="btn btn-success">Import</button>
                            </form>

                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
