<div class="row mt-2 mb-2" id="rowPakan{{ $c }}">
    <div class="col-lg-3">
        <div class="form-group">
            <select name="id_pakan[]" id="" persen="{{$c}}" class="form-control select2 persen_pakan pakan_input">
                <option value="">- Pilih Pakan -</option>
                @php
                    $pakan = DB::table('tb_barang_pv')->get();
                @endphp
                @foreach ($pakan as $p)
                    <option value="{{ $p->id_barang }}">{{ $p->nm_barang }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <input type="text" kd="{{$c}}" id="prsn{{$c}}" name="persenPakan[]" class="form-control pakan_input persen">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <input id="hasil{{$c}}" type="text" readonly name="pakanGr[]" class="form-control hasil">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <button class="btn btn-danger btn-md removePakan" type="button" count="{{$c}}"><i class="fa fa-minus"></i></button>
        </div>
    </div>
</div>