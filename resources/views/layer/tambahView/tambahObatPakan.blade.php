<div class="row mt-2 mb-2" id="rowObatPakan{{ $c }}">
    <div class="col-lg-3">
        <div class="form-group">
            @php
                $obat = DB::table('tb_barang_pv')->where('id_jenis', 2)->get();
            @endphp
            <select name="id_obatPakan[]" id="" detail="{{ $c }}" class="form-control select2 id_obat_pkn">
                <option value="">- Pilih Obat -</option>
                @foreach ($obat as $o)
                    <option value="{{ $o->id_barang }}">{{ $o->nm_barang }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            <input type="text" class="form-control" id="ds{{$c}}" name="dosisPakan[]">
        </div>
    </div>
    <div class="col-lg-1">
        <div class="form-group">
            <input type="text" readonly name="satuanObat[]" id="stn{{$c}}" class="form-control">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <input type="text" class="form-control" id="cmpr{{$c}}" name="obatCampuran[]">
        </div>
    </div>
    <div class="col-lg-1">
        <div class="form-group">
            <input type="text" readonly name="satuanObat2[]" id="stnc{{$c}}" class="form-control">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <button class="btn btn-danger btn-md removeObatPakan" count="{{$c}}" type="button"><i class="fa fa-minus"></i></button>
        </div>
    </div>
</div>