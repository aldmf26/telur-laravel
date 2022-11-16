<input type="hidden" name="id" value="{{ $ayam->id }}">
    <div class="row">
        <div class="col-md-4">
            <label for="">Tanggal</label>
            <input type="date" value="{{ $ayam->tgl }}" class="form-control" name="tgl">
        </div>
        <div class="col-md-4">
            <label for="">Bawa</label>
            <input type="text" value="{{ $ayam->bawa }}" class="form-control" name="bawa">
        </div>
        <div class="col-md-4">
            <label for="">Ekor</label>
            <input type="text" value="{{ $ayam->qty }}" class="form-control" name="qty">
        </div>
    </div>
