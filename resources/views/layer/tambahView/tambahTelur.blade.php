<div class="row mt-2 mb-2" id="row{{ $c }}">
    <br>
    <div class="col-lg-3 col-6">
        <label for=""
            style="font-weight: bold; font-family: Arial, Helvetica, sans-serif;">Kandang</label>
        <Select required class="form-control select2" name="id_kandang[]">
            @php
                $kandang = DB::table('tb_kandang')->where('selesai', 'T')->get();
                $jenis = DB::table('tb_jenis_telur')->get();
            @endphp
            <option value="">Kandang</option>
            @foreach ($kandang as $k)
                <option value="{{ $k->id_kandang }}">{{ $k->nm_kandang }}</option>
            @endforeach
        </Select>
    </div>

    @foreach ($jenis as $j)
        <input type="hidden" name="id_jenis[]" value="{{ $j->id }}">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Pcs {{ $j->jenis }}</label>
                <input type="text" value="0" class="form-control" name="pcs[]">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Kg {{ $j->jenis }}</label>
                <input type="text" value="0" class="form-control" name="kg[]">
            </div>
        </div>
    @endforeach
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Aksi</label><br>
            <button class="btn btn-danger removeTelur" count="{{$c}}" type="button"><i
                    class="fa fa-minus"></i></button>
        </div>
    </div>
</div>