<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Detail No Nota : {{ $penjualan->no_nota }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <h5>{{ $penjualan->tgl }}</h5>
            </div>
            <div class="col-md-6">
                <h5>{{ $penjualan->bawa }}</h5>
            </div>
        </div>
        <div class="row mt-3"></div>
        @php
            $tb_penjualan = DB::table('tb_penjualan')->get();
        @endphp
            <table id="table" class="table table-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        @foreach ($jenis as $j)
                        <th>Pcs {{ $j->jenis }}</th>
                        <th>Kg {{ $j->jenis }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tb_penjualan as $no => $t)
                        @php
                            $getJenis = DB::table('tb_jenis_telur')->where('id', $t->id_jenis)->get();
                        @endphp
                        <tr>
                            <td>{{ $no+1 }}</td>
                            @foreach ($getJenis as $n)
                                <td>{{ $t->pcs }}</td>
                                <td>{{ $t->kg }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button wire:click="saveDetail" type="button" class="btn btn-primary">Save changes</button>
    </div>
</div>