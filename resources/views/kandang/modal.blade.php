{{-- <input type="hidden" name="id" {{ $kandang->id_kandang }}> --}}
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Date Check-in</label>
            <input type="date" value="{{ $kandang->tgl_masuk }}" class="form-control" name="tgl_masuk">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Nama Kandang</label>
            <input type="text" value="{{ $kandang->nm_kandang }}" class="form-control" name="nm_kandang">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Strain</label>
            <select name="id_strain" id="" class="form-control select2">
                @foreach ($strain as $s)
                <option value="{{ $s->id_strain }}" {{ $s->id_strain == $kandang->id_strain ? 'selected' : '' }}>{{ $s->nm_strain }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Jumlah Ayam Awal</label>
            <input type="text" value="{{ $kandang->ayam_awal }}" class="form-control" name="ayam_awal">
        </div>
    </div>
</div>