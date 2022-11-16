<input type="hidden" name="id_obat" value="{{ $obat->id_barang }}">
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label>Nama Obat</label>
            <input type="text" value="{{ $obat->nm_barang }}" name="nm_obat" class="form-control">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Kegunaan</label>
            <input type="text" value="{{ $obat->kegunaan }}" class="form-control" name="kegunaan">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Jenis</label>
            <select name="id_jenis" id="" class="form-control select2">
                <option value="">- Jenis -</option>
                @foreach ($jenis as $j)
                    <option {{ $obat->id_jenis == $j->id_jenis ? 'selected' : '' }} value="{{ $j->id_jenis }}">{{ $j->nm_jenis }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Dosis</label>
            <input type="text" value="{{ $obat->dosis ?? 0 }}" class="form-control" name="dosis">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Satuan</label>
            <select name="satuan" id="" class="form-control select2">
                <option value="">Satuan</option>
                @foreach ($satuan as $s)
                    <option {{ $obat->id_satuan == $s->id_satuan ? 'selected' : '' }} value="{{ $s->id_satuan }}">{{ $s->nm_satuan }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Satuan</label>
            <select name="satuan2" id="" class="form-control select2">
                <option value="">Satuan</option>
                @foreach ($satuan as $sa)
                    <option {{ $obat->id_satuan_pakai == $sa->id_satuan ? 'selected' : '' }} value="{{ $sa->id_satuan }}">{{ $sa->nm_satuan }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Campuran</label>
            <input type="text" value="{{ $obat->campuran ?? 0 }}" class="form-control" name="campuran">
        </div>
    </div>
</div>
