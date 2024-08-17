<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (!$transaksi)
                    <button class="btn btn-primary" wire:click='transaksi_baru'>Transaksi Baru</button>
                @else
                    <button class="btn btn-danger" wire:click='batal_transaksi'>Batalkan Transaksi</button>
                @endif
                <button class="btn btn-info" wire:loading>Loading...</button>
            </div>
        </div>
        @if ($transaksi)
            <div class="row mt-3">
                <div class="col-8">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h4 class="card-title">Transaksi</h4>
                            <div class="row">
                                <div class="col-12">
                                    <input type="text" wire:model.live='kode' class="form-control">
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    @foreach ($semuaProduk as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->produk->kode }}</td>
                                            <td>{{ $item->produk->nama }}</td>
                                            <td>{{ number_format($item->produk->harga, '0', '', '.') }}</td>
                                            <td>{{ number_format($item->jumlah, '0', '', '.') }}</td>
                                            <td>{{ number_format($item->produk->harga * $item->jumlah, '0', '', '.') }}
                                            </td>
                                            <td>
                                                <button wire:click='hapusProduk({{ $item->id }})'
                                                    class="btn btn-danger">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card border-primary">
                        <div class="card-body">
                            <p class="card-text fw-bold">No Invoice : {{ $transaksi->no_invoice }} </p>
                            <div class="mb-3">
                                <div class="row">
                                    <h5>Total Belanja</h5>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp.</span>
                                        <span>{{ number_format($totalBelanja, '0', '', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h5>Bayar</h5>
                                <input type="number" wire:model.live='bayar' class="form-control">
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <h5>Kembalian</h5>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp.</span>
                                        <span>{{ number_format($kembalian, '0', '', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($bayar)
                        @if ($kembalian < 0)
                            <div class="alert alert-danger mt-2" role="alert">
                                Uang kurang
                            </div>
                        @elseif($kembalian > 0)
                            <button class="btn btn-success w-100 mt-2" wire:click='transaksi_selesai'>Bayar</button>
                        @endif
                    @endif


                </div>
            </div>
        @endif
    </div>
</div>
