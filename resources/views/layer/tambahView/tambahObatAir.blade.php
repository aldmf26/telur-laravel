<div class="row mt-2 mb-2" id="rowAir{{ $c }}">
    <div class="col-lg-3">
        <div class="form-group">
            <select name="id_obatAir[]" id="" detail="{{ $c }}" class="id_obat_air form-control select2">
                <option value="">- Pilih Obat -</option>
                @php
                    $obat_air = DB::table('tb_barang_pv')->where('id_jenis', 3)->get();
                @endphp
                @foreach ($obat_air as $o)
                    <option value="{{ $o->id_barang }}">{{ $o->nm_barang }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <input type="text" class="form-control" name="dosisAir[]">
        </div>
    </div>
    <div class="col-lg-1">
        <div class="form-group">
            <input type="text" id="stnAir{{$c}}" readonly name="satuanObatAir[]" class="form-control">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <input type="text" class="form-control" name="obatCampuranAir[]">
        </div>
    </div>
    <div class="col-lg-1">
        <div class="form-group">
            <input type="text" id="stncAir{{$c}}" readonly name="satuanObatAir2[]" class="form-control">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <input type="time" name="waktuObat[]" class="form-control">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <input type="text" name="caraPemakaian[]" class="form-control">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <input type="text" name="ket[]" class="form-control">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <button class="btn btn-danger btn-md removeObatAir" type="button" count="{{$c}}"><i class="fa fa-minus"></i></button>
        </div>
    </div>
</div>