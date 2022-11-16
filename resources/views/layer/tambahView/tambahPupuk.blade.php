<div class="row mt-2 mb-2" id="row{{ $c }}">
    <div class="col-lg-5 col-6">
        <Select class="form-control select2" name="id_kandang[]">
            <option value="">Kandang</option>
            @php
                $kandang = DB::table('tb_kandang')->where('selesai', 'T')->get();
            @endphp
            @foreach ($kandang as $k) 
                <option value="{{ $k->id_kandang }}">{{$k->nm_kandang}}</option>
            @endforeach
        </Select>
    </div>

    <div class="col-lg-5 col-6">
        <input type="text" name="jumlah[]" class="form-control ">
    </div>
   
   
    <div class="col-lg-1 col-2">
        <button type="button" class="btn btn-danger btn-sm removePupuk" count="{{$c}}"><i class="fas fa-minus"></i></button>
    </div>
</div>