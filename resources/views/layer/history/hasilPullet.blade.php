<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead class="table table-secondary text-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Nama</th>
                            <th>Qty</th>
                            <th>Pgws</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pakan as $no => $p)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ date('d-m-Y', strtotime($p->tgl)) }}</td>
                                <td>{{ $p->nm_jenis }}</td>
                                <td>{{ $p->nm_barang }}</td>
                                <td>{{ $p->qty }}</td>
                                <td>{{ $p->admin }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>