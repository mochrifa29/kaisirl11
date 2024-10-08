<div>
    <div class="container">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card border-primary">
                    <div class="card-body">
                        <h4 class="card-title">Laporan Transaksi</h4>
                        <div class="row mb-3">
                            <div class="col-2">
                                <a href="{{ url('cetak') }}" target="_blank" class="btn btn-primary">Cetak Laporan</a>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>No Inv</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                @foreach ($laporan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->no_invoice }}</td>
                                        <td>Rp. {{ number_format($item->total, '0', '', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
