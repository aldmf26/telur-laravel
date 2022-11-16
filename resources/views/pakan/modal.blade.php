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

