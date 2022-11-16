<div class="row mb-4">

    <div class="col-lg-12"></div>
    <br>
    <div class="col-lg-3 col-6">
        <label for=""
            style="font-weight: bold; font-family: Arial, Helvetica, sans-serif;">Kandang</label>
        <input type="text" readonly name="id_kandang" value="{{ $kandangData->nm_kandang }}" class="form-control">
    </div>

    @foreach ($jenis as $j)
    @php
        $jenisTelur = DB::table('tb_telur')->where([['nota', $kandangData->nota],['id_jenis', $j->id],['tgl',$tgl]])->first();
        // dd($jenisTelur);
        $pcsJt = empty($jenisTelur->pcs) ? 0 : $jenisTelur->pcs;
        $kgJt = empty($jenisTelur->kg) ? 0 : $jenisTelur->kg;
    @endphp
        <input type="hidden" name="id_telur[]" value="{{ $jenisTelur->id_telur }}">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Pcs {{ $j->jenis }}</label>
                <input value="{{ $pcsJt }}" type="text" class="form-control" name="pcs[]">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Kg {{ $j->jenis }}</label>
                <input value="{{ $kgJt }}" type="text" class="form-control" name="kg[]">
            </div>
        </div>
    @endforeach
    {{-- <div class="col-lg-3">
        <div class="form-group">
            <label for="">Aksi</label><br>
            <button class="btn btn-primary" id="tambah_telur" type="button"><i
                    class="fa fa-plus"></i></button>
        </div>
    </div> --}}
</div>