<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Tanggal</label>
            <input required type="date" value="{{ $penjualan->tgl }}" name="tgl" class="form-control">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Bawa</label>
            <input required type="text" value="{{ $penjualan->bawa }}" name="bawa" class="form-control">
        </div>
    </div>
    @foreach ($jenis as $j)
    @php
        $jenisTelur = DB::table('tb_penjualan_telur')->where([['nota', $penjualan->nota],['id_jenis', $j->id]])->first();
    @endphp
                            <input type="hidden" name="id_penjualan[]" value="{{ $jenisTelur->id_penjualan }}">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Pcs {{ $j->jenis }}</label>
                                    <input type="text" value="{{ $jenisTelur->pcs }}" class="form-control" name="pcs[]">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Kg {{ $j->jenis }}</label>
                                    <input type="text" value="{{ $jenisTelur->kg }}" class="form-control" name="kg[]">
                                </div>
                            </div>
                            @endforeach
</div>