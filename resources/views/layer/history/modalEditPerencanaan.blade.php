<div class="row">
    <div class="col-lg-4">
        <label for="">Tanggal</label>
        <input required type="date" name="tgl" value="{{ $tgl }}" class="form-control tgl1">
    </div>
    <div class="col-lg-4">
        <label for="">Kandang</label>
        <select required name="id_kandang" id="kandangPerencanaan" class="form-control select2 id_populasi2">
            <option value="">- Pilih Kandang -</option>
            @foreach ($kandang as $k)
                <option {{$k->id_kandang == $id_kandang ? 'selected' : ''}} value="{{ $k->id_kandang }}">{{ $k->nm_kandang }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-3">
        <label for="">Kg pakan/box</label>
        <input type="text" id="krngEdit" name="kgPakanBox" class="form-control pakan_input" value="{{ $karung->karung }}">
        <input type="hidden" class="form-control pakan_input" name="id_krng" value="<?= $karung->id_krng ?>">
        <input type="hidden" name="id_no_nota" value="{{ $karung->no_nota }}">
    </div>
</div>

<hr style="border: 1px solid #6777EF;">
<h5 style="text-decoration: underline">Pakan</h5>
{{-- pakan --}}
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Populasi</label>
            <input value="{{ $populasi->populasi }}" type="text" id="getPopulasiEdit" readonly name="populasi" class="form-control">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Gr Pakan / Ekor</label>
            <input value="{{ number_format(($gr_pakan->ttl / $populasi->populasi) * 1000, 0) }}" type="text" id="grEdit" name="grPakanEkor" class="form-control pakan_input">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Kg/karung</label>
            <input value="{{ $karung->gr }}" type="text" id="krng_fEdit" readonly name="kgKarung" class="form-control">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Kg/karung sisa</label>
            <input value="{{ $karung->gr2 }}" type="text" readonly id="krng_sEdit" name="kgKarungSisa" class="form-control">
        </div>
    </div>
</div>
@php
    $i = 1;
    $l = 1;
@endphp
@foreach ($pakan_id as $pk)
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Type</label>
                <input type="hidden" name="id_dt_pakan[]" value="{{ $pk->id_pakan }}">
                <select name="id_pakan[]"  persen="1" class="form-control select2 persen_pakan pakan_input">
                    <option value="">- Pilih Pakan -</option>
                    @foreach ($pakan as $p)
                        <option {{ $p->id_barang == $pk->id_barang ? 'selected' : '' }} value="{{ $p->id_barang }}">{{ $p->nm_barang }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="">%</label>
                <input type="text" id="prsn1" name="persenPakan[]" class="form-control pakan_input persenEdit" kd="{{ $i++ }}" value="{{ !$gr_pakan->ttl  ? 0 : ($pk->gr_pakan * 100) / $gr_pakan->ttl }}">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Pakan (Gr)</label>
                <input type="text" readonly name="pakanGr[]" id="hasilEdit{{$l++}}" value="{{ $pk->gr_pakan * 1000 }}" class="form-control hasilEdit">
            </div>
        </div>
    </div>
@endforeach
<div class="row">
    <div class="col-lg-3">
    </div>
    <div class="col-lg-2">
    </div>
    <div class="col-lg-3">
        <hr style="border: 1px solid #6777EF;">
        <input value="{{ $gr_pakan->ttl * 1000 }}" type="text" readonly name="pakanGrTotal" id="totalEdit" class="form-control">
    </div>
</div>

<h5 style="text-decoration: underline">Obat/vit dengan campuran pakan</h5>
@foreach ($obat_pakan as $obt)
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="">Obat</label>
                <input type="hidden" name="id_obat_pkn[]" value="{{ $obt->id_obat }}">
                <select name="id_obatPakan[]" id="" class="form-control select2 id_obat_pkn" detail="1">
                    <option value="">- Pilih Obat -</option>
                    @foreach ($obat as $o)
                        <option {{ $obt->id_obat == $o->id_barang ? 'selected' : '' }} value="{{ $o->id_barang }}">{{ $o->nm_barang }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="">Dosis</label>
                <input value="{{ $obt->dosis }}" type="text" class="form-control" id="ds1" name="dosisPakan[]">
            </div>
        </div>
        <div class="col-lg-1">
            <div class="form-group">
                <label for="">Satuan</label>
                <input value="{{ $obt->satuan }}" type="text" readonly name="satuanObat[]" id="stn1" class="form-control">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="">Campuran</label>
                <input value="{{ $obt->campuran }}" type="text" class="form-control" id="cmpr1" name="obatCampuran[]">
            </div>
        </div>
        <div class="col-lg-1">
            <div class="form-group">
                <label for="">Satuan</label>
                <input value="{{ $obt->satuan2 }}" type="text" id="stnc1" readonly name="satuanObat2[]" class="form-control">
            </div>
        </div>
    </div>
@endforeach
<h5 style="text-decoration: underline">Obat/vit dengan campuran air</h5>
@foreach ($obat_air as $oba)
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Obat</label>
            <input type="hidden" name="id_obat_air2[]" value="{{ $oba->id_obat_air }}">
            <select name="id_obatAir[]" id="" detail="1" class="form-control select2 id_obat_air">
                <option value="">- Pilih Obat -</option>
                @foreach ($obat_air2 as $o)
                    <option {{ $o->id_barang == $oba->id_obat ? 'selected' : '' }} value="{{ $o->id_barang }}">{{ $o->nm_barang }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Dosis</label>
            <input type="text" value="{{ $oba->dosis }}" class="form-control" name="dosisAir[]">
        </div>
    </div>
    <div class="col-lg-1">
        <div class="form-group">
            <label for="">Satuan</label>
            <input type="text" id="stnAir1" value="{{ $oba->satuan }}" readonly name="satuanObatAir[]" class="form-control">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Campuran</label>
            <input type="text" class="form-control" value="{{ $oba->campuran }}" name="obatCampuranAir[]">
        </div>
    </div>
    <div class="col-lg-1">
        <div class="form-group">
            <label for="">Satuan</label>
            <input type="text" id="stncAir1" value="{{ $oba->satuan2 }}" readonly name="satuanObatAir2[]" class="form-control">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Waktu</label><br>
            <input type="time" name="waktuObat[]" value="{{ $oba->waktu }}" class="form-control">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Cara Pemakaian</label>
            <input type="text" name="caraPemakaian[]" value="{{ $oba->cara }}" class="form-control">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Keterangan</label>
            <input type="text" name="ket[]" value="{{ $oba->ket }}" class="form-control">
        </div>
    </div>
</div>
@endforeach

<h5 style="text-decoration: underline">Obat/ekor ayam</h5>
@foreach ($obat_aym as $tot)    
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Obat</label>
            <input type="hidden" name="id_obat_ayam" value="{{ $tot->id_obat_ayam }}">
            <select name="id_obatAyam" id="obatAyam" class="form-control select2">
                <option value="">- Pilih Obat -</option>
                @foreach ($obat_ayam as $o)
                    <option {{ $o->id_barang == $tot->id_obat ? 'selected' : '' }} value="{{ $o->id_barang }}">{{ $o->nm_barang }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Dosis</label>
            <input type="text" value="{{ $tot->dosis_awal }}" class="form-control" id="ds1" name="dosisObatAyam">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Satuan</label>
            <input type="text" value="{{ $tot->satuan }}" id="satuanObatAyam" readonly class="form-control" id="stn1" name="obatAyamSatuan">
        </div>
    </div>
</div>
@endforeach