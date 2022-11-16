<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Tanggal</label>
            <input required type="date" value="{{ $solar->tgl }}" class="form-control" name="tgl">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Qty</label>
            <input required type="text" value="{{ $solar->kredit }}" class="form-control" name="kredit">
        </div>
    </div>
    <div class="col-lg-5">
        <div class="form-group">
            <label for="">Keterangan</label>
            <input type="text" value="{{ $solar->ket }}" class="form-control" name="ket">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Satuan</label>
            <input type="text" readonly class="form-control" value="Liter">
        </div>
    </div>
</div>