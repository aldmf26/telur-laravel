@extends('layouts.app')
@section('content')
    <style>
        .ayam {
            white-space: nowrap;
            font-size: 8.7px;
        }

        .td_ayam {
            font-size: 12px
        }

        th,
        td {
            padding: 8px;
        }
        .modal-lg-max {
            max-width: 1000px;
        }
        .hova:hover {
            background-color: #4054ee;
        }
    </style>

    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6 col-sm-2 mb-1">
                                    <a href="" data-target="#inputPerencanaan" data-toggle="modal" class="btn btn-primary btn-block btn-sm"><i class="fa fa-plus"></i>
                                        Input Perencenaan</a>
                                </div>
                                <div class="col-6 col-sm-2 mb-1">
                                    <a href="#" data-target="#history" data-toggle="modal" class="btn btn-primary btn-block btn-sm">History</a>
                                </div>
                                <div class="col-6 col-sm-2 mb-1">

                                    <a href="{{ route('export') }}" class="btn btn-primary btn-block btn-sm">Export</a>
                                </div>
                                <div class="col-6 col-sm-2 mb-1">

                                    <a href="" data-target="#exportDailyLayer" data-toggle="modal" class="btn btn-primary btn-block btn-sm">Export Daily Layer</a>
                                </div>
                                <div class="col-6 col-sm-2 mb-1">

                                    <a href="{{ route('kandang') }}" target="_blank"
                                        class="btn btn-primary btn-block btn-sm"><i class="fa fa-plus"></i>
                                        Input Kandang</a>
                                </div>
                                <div class="col-6 col-sm-2 mb-1">
                                    <a href="#" data-target="#laporanLayer" data-toggle="modal" class="btn btn-primary btn-block btn-sm"><i
                                            class="fa fa-file-excel"></i> Laporan Layer</a></a>
                                </div>
                                <div class="col-6 col-sm-2 mt-1">
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-primary btn-block btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Database
                                        </button>
                                        <div class="dropdown-menu bg-info" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                          <a class="dropdown-item has-icon text-white hova" href="{{ route('obat') }}" target="_blank"><i class="fa fa-pills"></i> Obat</a>
                                          <a class="dropdown-item has-icon text-white hova" href="{{ route('pakan') }}" target="_blank"><i class="fa fa-seedling"></i> Pakan</a>
                                        </div>
                                      </div>
                                    {{-- <a href="{{ route('obat') }}" target="_blank"
                                        class="btn btn-primary btn-block btn-sm"><i class="fa fa-pills"></i>
                                        Database Obat</a></a> --}}
                                </div>
                                <div class="col-6 col-sm-2 mt-1">
                                    <a href="#" data-target="#hargaPakan" data-toggle="modal" class="btn btn-primary btn-block btn-sm"><i class="fa fa-coins"></i>
                                        Harga Pakan</a></a>
                                </div>
                                <div class="col-6 col-sm-2 mt-1">
                                    <button type="button" id="btnInputvaksin" data-target="#inputVaksin"
                                        data-toggle="modal" class="btn btn-primary btn-block btn-sm"><i
                                            class="fa fa-syringe"></i>
                                        Input Vaksin</button></a>
                                </div>
                            </div>
                        </div>
                        @include('layouts.alert')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-primary">
                                    <div class="card-header" style="margin-bottom: 0px;">
                                        <h4>Stok : {{ date('d-m-Y') }}</h4>
                                    </div>
                                    <div class="card-body" style="margin-top: 0px">
                                        <table class="table-responsive">
                                            <thead
                                                style="font-family: Helvetica; color: rgb(120, 144, 156); background-color: rgb(244, 248, 249); text-transform: uppercase; --darkreader-inline-color:#cac0b0; --darkreader-inline-bgcolor:#223338;"
                                                data-darkreader-inline-color="" data-darkreader-inline-bgcolor="">
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="3%"
                                                        style="font-size: 12px; font-weight: bold; white-space: nowrap;">
                                                        <a href="#"
                                                            style="font-size: 12px; color: rgb(120, 120, 120); text-transform: uppercase; --darkreader-inline-color:#c7bdad;"
                                                            data-toggle="modal">
                                                            @foreach ($data_barang as $d)
                                                                {{ $d->nm_barang }}<br>
                                                            @endforeach
                                                            @foreach ($jenis as $t)
                                                                Pcs {{ ucwords($t->jenis) }} <br>
                                                                Kg {{ucwords($t->jenis)}} <br>
                                                            @endforeach
                                                            
                                                        </a>
                                                    </td>
                                                    <td width="1%" style="font-size: 12px; font-weight: bold;">
                                                        @foreach ($data_barang as $d)
                                                            : <br>
                                                        @endforeach
                                                        @foreach ($jenis as $j)
                                                            : <br> 
                                                            : <br> 
                                                        @endforeach
                                                    </td>
                                                    <td style="text-align: right; font-size: 12px; font-weight: bold; white-space: nowrap;"
                                                        width="3%">
                                                        @foreach ($data_barang as $d)
                                                        @php
                                                           $stok = DB::selectOne("SELECT a.id_barang,SUM(b.debit - b.kredit) as stok FROM `tb_barang_pv` as a
                                                                    LEFT JOIN tb_asset_pv as b ON a.id_barang = b.id_barang
                                                                    WHERE b.id_barang = '$d->id_barang'"); 
                                                        @endphp
                                                            {{ $stok->stok ?? 0 }} <span>{{ strtolower($d->nm_satuan) }}</span> <br>
                                                        @endforeach
                                                        @foreach ($jenis as $t)
                                                            @php
                                                                $sumJenis = DB::selectOne("SELECT sum(pcs) as pcs, sum(kg) as kg FROM tb_telur 
                                                                            WHERE id_jenis = '$t->id' GROUP BY id_jenis");
                                                            @endphp
                                                            {{ $sumJenis->pcs }} <br>
                                                            {{ $sumJenis->kg }} <br>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h4>Laporan layer {{ date('d-m-Y') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive-sm">
                                            {{-- @livewire('layer.table-layer') --}}
                                            <table style="width: 100%;" border="1" cel="10">
                                                <thead
                                                    style="font-family: Helvetica; color: #78909C; background-color: #F4F8F9; text-transform: uppercase;">
                                                    <tr>
                                                        <th></th>
                                                        <th class="ayam">Umur </th>
                                                        <th class="ayam">pop akhir/D/C</th>
                                                        <th class="ayam">
                                                            @foreach ($jenis as $j)
                                                                {{ ($j->jenis) }} / 
                                                            @endforeach
                                                            Ttl Kg
                                                        </th>
                                                        <th class="ayam">Pupuk</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <tr>
                                                        <td class="td_ayam">
                                                            @foreach ($kandangData as $d)
                                                                <a href="#" data-toggle="modal"
                                                                    data-target="#history{{ $d->id_kandang }}">{{ $d->nm_kandang }}</a>
                                                                <br>
                                                            @endforeach
                                                        </td>
                                                        <td style="white-space: nowrap;" class="td_ayam">
                                                            @foreach ($kandangData as $d)
                                                                <a href="#"
                                                                    class="{{ $d->mgg + 1 >= 32 ? 'text-danger' : '' }}">{{ $d->mgg + 1 }}
                                                                    / {{number_format((($d->mgg + 1) / 90) * 100,0)}}%</a> <br>
                                                            @endforeach
                                                        </td>
                                                        <td style="white-space: nowrap;"  class="td_ayam">
                                                            @foreach ($kandangData as $d)
                                                            @php
                                                                // $populasi = DB::selectOne("SELECT sum(populasi) as populasi, sum(death) as death,sum(culling) as culling FROM tb_populasi 
                                                                //             WHERE id_kandang = '$d->id_kandang'and tgl = '$tglhariIni' GROUP BY id_kandang");
                                                                $populasi = Db::selectOne("SELECT dt.id_kandang, dt.death , dt.culling, sum(dt.populasi) as populasi FROM tb_populasi as dt
                                                                                LEFT JOIN (SELECT MAX(b.tgl) AS tgl_max, b.id_kandang FROM tb_populasi AS b WHERE b.id_kandang = '$d->id_kandang' GROUP BY b.id_kandang) AS mx ON mx.id_kandang = dt.id_kandang
                                                                                        WHERE dt.tgl = mx.tgl_max")
                                                            @endphp
                                                                <a href="#" data-toggle="modal"
                                                                    data-target="#populasi">{{ empty($populasi->populasi) ? 0 : $populasi->populasi }} / <span
                                                                        class="text-danger">{{ empty($populasi->death) ? 0 : $populasi->death }} / {{ empty($populasi->culling) ? 0 : $populasi->culling }}</span></a> <br>
                                                            @endforeach
                                                        </td>
                                                        <td style="white-space: nowrap;" class="td_ayam">
                                                            
                                                            @foreach ($kandangData as $d)
                                                                <a href="#" data-toggle="modal" data-target="#telur"> 
                                                                    @php
                                                                        $ttlKg = 0;
                                                                    @endphp
                                                                    @foreach ($jenis as $j)
                                                                        @php
                                                                            $sumJenis = DB::selectOne("SELECT sum(pcs) as tPcs, sum(kg) as tKg FROM tb_telur 
                                                                            WHERE id_kandang = '$d->id_kandang' and id_jenis = '$j->id' and tgl = '$tglhariIni' GROUP BY id_kandang");

                                                                            $sumKemarin = DB::selectOne("SELECT sum(pcs) as tPcs, sum(kg) as tKg FROM tb_telur 
                                                                            WHERE id_kandang = '$d->id_kandang' and id_jenis = '$j->id' and tgl = '$tglKemarin' GROUP BY id_kandang");
                                                                            $ttlKg += empty($sumJenis->tKg) ? 0 : $sumJenis->tKg;
                                                                            $tPcs = empty($sumJenis->tPcs) ? 0 : $sumJenis->tPcs;
                                                                        @endphp
                                                                        {{$tPcs}} /
                                                                    @endforeach
                                                                    {{ $ttlKg }}
                                                                    <span class="text-danger">({{ empty($sumKemarin->tPcs) ? $tPcs - 0 : $tPcs - $sumKemarin->tPcs }})</span></a> <br>
                                                            @endforeach
                                                        </td>
                                                        <td style="white-space: nowrap;" class="td_ayam">
                                                            @foreach ($kandangData as $d)
                                                            @php
                                                                $karung = DB::selectOne("SELECT sum(jumlah) as jml FROM tb_pupuk 
                                                                            WHERE id_kandang = '$d->id_kandang' and tgl = '$tglhariIni' GROUP BY id_kandang")
                                                            @endphp
                                                                <a href="#" data-toggle="modal"
                                                                    data-target="#pupuk">{{ empty($karung->jml) ? 0 : $karung->jml }} Karung</a> <br>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- input perencanaan --}}
        <form action="{{ route('inputPerencanaan') }}" method="post">
            @csrf
            <div class="modal fade" tabindex="-1" role="dialog" id="inputPerencanaan">
                <div class="modal-dialog modal-lg-max" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Input Perencanaan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="">Tanggal</label>
                                    <input required type="date" name="tgl" id="tglPerencanaan" class="form-control">
                                </div>
                                <div class="col-lg-4">
                                    <label for="">Kandang</label>
                                    <select required name="id_kandang" id="kandangPerencanaan" class="form-control select2">
                                        <option value="">- Pilih Kandang -</option>
                                        @foreach ($kandangData as $k)
                                            <option value="{{ $k->id_kandang }}">{{ $k->nm_kandang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Kg pakan/box</label>
                                    <input type="text" id="krng" name="kgPakanBox" class="form-control pakan_input">
                                </div>
                            </div>
                            
                            <hr style="border: 1px solid #6777EF;">
                            <h5 style="text-decoration: underline">Pakan</h5>
                            {{-- pakan --}}
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Populasi</label>
                                            <input type="text" id="getPopulasi" readonly name="populasi" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Gr Pakan / Ekor</label>
                                            <input type="text" id="gr" name="grPakanEkor" class="form-control pakan_input">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Kg/karung</label>
                                            <input type="text" id="krng_f" readonly name="kgKarung" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Kg/karung sisa</label>
                                            <input type="text" readonly id="krng_s" name="kgKarungSisa" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Type</label>
                                            <select name="id_pakan[]" id="" persen="1" class="form-control select2 persen_pakan pakan_input">
                                                <option value="">- Pilih Pakan -</option>
                                                @foreach ($pakan as $p)
                                                    <option value="{{ $p->id_barang }}">{{ $p->nm_barang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">%</label>
                                            <input type="text" id="prsn1" name="persenPakan[]" class="form-control pakan_input persen" kd="1">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Pakan (Gr)</label>
                                            <input type="text" readonly name="pakanGr[]" id="hasil1" class="form-control hasil">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Aksi</label><br>
                                            <button class="btn btn-primary btn-md pakan_input" type="button" id="tbhPakan"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div id="detail_pakan"></div>
                                <div class="row">
                                    <div class="col-lg-3">
                                    </div>
                                    <div class="col-lg-2">
                                    </div>
                                    <div class="col-lg-3">
                                        <hr style="border: 1px solid #6777EF;">
                                        <input type="text" readonly name="pakanGrTotal" id="total" class="form-control">
                                    </div>
                                </div>
                            {{-- --------------- --}}

                            <h5 style="text-decoration: underline">Obat/vit dengan campuran pakan</h5>
                            {{-- obat campuran pakan--}}
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Obat</label>
                                            <select name="id_obatPakan[]" id="" class="form-control select2 id_obat_pkn" detail="1">
                                                <option value="">- Pilih Obat -</option>
                                                @foreach ($obat as $o)
                                                    <option value="{{ $o->id_barang }}">{{ $o->nm_barang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Dosis</label>
                                            <input type="text" class="form-control" id="ds1" name="dosisPakan[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label for="">Satuan</label>
                                            <input type="text" readonly name="satuanObat[]" id="stn1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Campuran</label>
                                            <input type="text" class="form-control" id="cmpr1" name="obatCampuran[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label for="">Satuan</label>
                                            <input type="text" id="stnc1" readonly name="satuanObat2[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Aksi</label><br>
                                            <button class="btn btn-primary btn-md" type="button" id="tbhObatPakan"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div id="detail_obatPakan"></div>
                            {{-- ---------------- --}}

                            <h5 style="text-decoration: underline">Obat/vit dengan campuran air</h5>
                            {{-- obat campuran air --}}
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Obat</label>
                                            <select name="id_obatAir[]" id="" detail="1" class="form-control select2 id_obat_air">
                                                <option value="">- Pilih Obat -</option>
                                                @foreach ($obat_air as $o)
                                                    <option value="{{ $o->id_barang }}">{{ $o->nm_barang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Dosis</label>
                                            <input type="text" class="form-control" name="dosisAir[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label for="">Satuan</label>
                                            <input type="text" id="stnAir1" readonly name="satuanObatAir[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Campuran</label>
                                            <input type="text" class="form-control" name="obatCampuranAir[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label for="">Satuan</label>
                                            <input type="text" id="stncAir1" readonly name="satuanObatAir2[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Waktu</label><br>
                                            <input type="time" name="waktuObat[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Cara Pemakaian</label>
                                            <input type="text" name="caraPemakaian[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Keterangan</label>
                                            <input type="text" name="ket[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Aksi</label><br>
                                            <button class="btn btn-primary btn-md" type="button" id="tbhObatAir"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div id="detail_obatAir"></div>
                            {{-- --------------------- --}}

                            <h5 style="text-decoration: underline">Obat/ekor ayam</h5>
                            {{-- obat ekor ayam --}}
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Obat</label>
                                            <select name="id_obatAyam" id="obatAyam" class="form-control select2">
                                                <option value="">- Pilih Obat -</option>
                                                @foreach ($obat_ayam as $o)
                                                    <option value="{{ $o->id_barang }}">{{ $o->nm_barang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Dosis</label>
                                            <input type="text" class="form-control" id="ds1" name="dosisObatAyam">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="">Satuan</label>
                                            <input type="text" id="satuanObatAyam" readonly class="form-control" id="stn1" name="obatAyamSatuan">
                                        </div>
                                    </div>
                                </div>
                            {{-- ---------------------- --}}
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    {{-- --------------------------------- --}}

    {{-- history --}}
        <div class="modal fade" tabindex="-1" role="dialog" id="history">
            <div class="modal-dialog modal-lg-max" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Input Populasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <a data-toggle="collapse" href="#perencanaan" class="btn btn-sm btn-primary">History Perencanaan</a>
                                <button data-toggle="collapse" data-target="#layer" type="button" class="btn btn-sm btn-primary">History Layer</button>
                                <button data-toggle="collapse" data-target="#pullet" type="button" class="btn btn-sm btn-primary">History Pullet</button>
                                <button data-toggle="collapse" data-target="#stok" type="button" class="btn btn-sm btn-primary">History Stok</button>
                            </div>
                        </div>
                        <hr style="border: 1px solid #6777EF;">
                        <div class="collapse multi-collapse" id="perencanaan">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="">Tanggal</label>
                                    <input type="date" name="tglPerencanaan" id="tglHistoryPerencanaan" class="form-control">
                               </div>
                               <div class="col-lg-3">
                                    <label for="">Kandang</label>
                                    <select name="id_kandangPerencanaan" id="id_kandangPerencanaan" class="form-control select2">
                                        <option value="">- Pilih Kandang -</option>
                                        @foreach ($kandangData as $d)
                                            <option value="{{ $d->id_kandang }}">{{ $d->nm_kandang }}</option>
                                        @endforeach
                                    </select>
                               </div>
                               <div class="col-lg-2">
                                    <label for="">Aksi</label><br>
                                    <button type="button" class="btn btn-md btn-primary" id="btnPerencanaan">View</button>
                               </div>
                            </div>
                            <div id="hasilPerencanaan" class="mt-3"></div>
                            <br>
                        </div>

                        <div class="collapse multi-collapse" id="layer">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="">Tanggal</label>
                                    <input type="date" id="tglLayer" class="form-control">
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Aksi</label><br>
                                    <button type="button" class="btn btn-md btn-primary" id="btnLayer">View</button>
                                </div>
                            </div>
                            <div id="hasilLayer" class="mt-3"></div>
                           
                            <br>
                        </div>

                        <div class="collapse multi-collapse" id="pullet">
                            <div class="row">
                                <div class="col-lg-3">
                                     <label for="">Kandang</label>
                                     <select name="id_kandangPullet" id="id_kandangPullet" class="form-control select2">
                                         <option value="">- Pilih Kandang -</option>
                                         @foreach ($kandangData as $d)
                                             <option value="{{ $d->id_kandang }}">{{ $d->nm_kandang }}</option>
                                         @endforeach
                                     </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Dari</label>
                                    <input type="date" name="tglDariPullet" id="tglDariPullet" class="form-control">
                               </div>
                                <div class="col-lg-3">
                                    <label for="">Sampai</label>
                                    <input type="date" name="tglSampaiPullet" id="tglSampaiPullet" class="form-control">
                               </div>
                               <div class="col-lg-2">
                                    <label for="">Aksi</label><br>
                                    <button type="button" class="btn btn-md btn-primary" id="btnPullet">View</button>
                               </div>
                            </div>
                            <div id="hasilPullet" class="mt-3"></div>
                            <br>
                        </div>

                        <div class="collapse multi-collapse" id="stok">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="">Tanggal</label>
                                    <input type="date" id="tglStok" class="form-control">
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Aksi</label><br>
                                    <button type="button" class="btn btn-md btn-primary" id="btnStok">View</button>
                                </div>
                            </div>
                            <div id="hasilStok" class="mt-3"></div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    {{-- ----------------------- --}}
    
    {{-- edit perencanaan --}}
        <form action="{{ route('editPerencanaan') }}" method="post">
            @csrf
            <div class="modal fade" id="edit_perencanaan">
                <div class="modal-dialog modal-lg-max">
                    <div class="modal-content">
                        <div class="modal-header bg-custome">
                            <h4 class="modal-title">Edit perencanaan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="hasilEditPerencanaan"></div>
        
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm save_btn">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    {{-- ------------------- --}}

    {{-- harga pakan --}}
        <div class="modal fade" tabindex="-1" role="dialog" id="hargaPakan">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Harga Pakan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover" id="table3">
                            <thead class="">
                                <tr>
                                    <th>Nama Pakan</th>
                                    <th>Tanggal</th>
                                    <th>Harga Beli</th>
                                    <th>Qty</th>
                                    <th>Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($harga_pakan as $h)
                                    <tr>
                                        <td>{{ $h->nm_barang }}</td>
                                        <td>{{ date('d-m-Y', strtotime($h->tgl)) }}</td>
                                        <td>{{ number_format($h->debit,0) }}</td>
                                        <td>{{ number_format($h->qty,0) }}</td>
                                        <td>{{ number_format($h->debit / $h->qty,0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    
                    </div>
                </div>
            </div>
        </div>
    {{-- ----------------------- --}}

    {{-- export daily --}}
        <form action="{{ route('exportDaily') }}" method="post">
            @csrf
            <div class="modal fade" tabindex="-1" role="dialog" id="exportDailyLayer">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Export Daily</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="">Pilih Kandang</label>
                            <select name="id_kandang" id="" class="form-control select2">
                                @foreach ($kandangData as $k)
                                    <option value="{{ $k->id_kandang }}">{{ $k->nm_kandang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    {{-- ------------------------ --}}

    {{-- laporan layer --}}
        <form action="{{ route('laporanLayer') }}" method="post">
            @csrf
            <div class="modal fade" tabindex="-1" role="dialog" id="laporanLayer">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Laporan Layer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="">Tanggal</label>
                            <input type="date" value="{{ date('Y-m-d') }}" name="tgl" class="form-control">
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    {{-- ------------------------------------ --}}

    {{-- input populasi --}}
        <form action="{{ route('addPopulasi') }}" method="post">
            @csrf
            <div class="modal fade" tabindex="-1" role="dialog" id="populasi">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Input Populasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-lg-5 col-7">
                                    <label for=""
                                        style="font-weight: bold; font-family: Arial, Helvetica, sans-serif;">Tanggal</label>
                                    <input type="date" name="tgl" value="<?= date('Y-m-d') ?>" class="form-control">
                                </div>
                                <div class="col-lg-12"></div>
                                <br>
                                <div class="col-lg-4 col-6">
                                    <label for=""
                                        style="font-weight: bold; font-family: Arial, Helvetica, sans-serif;">Kandang</label>
                                    <Select class="form-control select2" name="id_kandang[]">
                                        <option value="">Kandang</option>
                                        @foreach ($kandangData as $k)
                                            <option value="{{ $k->id_kandang }}">{{ $k->nm_kandang }}</option>
                                        @endforeach
                                    </Select>
                                </div>

                                <div class="col-lg-3 col-6">
                                    <label for=""
                                        style="font-weight: bold;font-family: Arial, Helvetica, sans-serif;">Mati/Death</label>
                                    <input type="text" name="mati[]" class="form-control  ">
                                </div>
                                <div class="col-lg-3 col-6">
                                    <label for=""
                                        style="font-weight: bold;font-family: Arial, Helvetica, sans-serif;">Jual/culling</label>
                                    <input type="text" name="jual[]" class="form-control  ">
                                </div>


                                <div class="col-lg-1 col-2">
                                    <label for=""
                                        style="font-weight: bold;font-family: Arial, Helvetica, sans-serif;">Aksi</label>
                                    <button id="tambah_populasi" type="button" class="btn btn-primary btn-sm"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div id="detail_populasi">

                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    {{-- ----------------------- --}}

    {{-- input vaksin --}}
        <form action="{{ route('addVaksin') }}" method="post">
            @csrf
            <div class="modal fade" tabindex="-1" role="dialog" id="inputVaksin">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Input Vaksin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Tanggal</label>
                                        <input type="date" class="form-control" name="tgl">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Kandang</label>
                                        @php
                                            $kandang = DB::table('tb_kandang')
                                                ->where('selesai', 'T')
                                                ->get();
                                        @endphp
                                        <select name="id_kandang" id="" class="form-control select2">
                                            <option value="">- Pilih Kandang -</option>
                                            @foreach ($kandang as $k)
                                                <option value="{{ $k->id_kandang }}">{{ $k->nm_kandang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Nama vaksin</label>
                                        <input type="text" class="form-control" name="nm_vaksin">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Dosis</label>
                                        <input type="text" class="form-control" name="dosis">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Cost vaksin</label>
                                        <input type="text" class="form-control" name="cost">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    {{-- ----------------------- --}}

    {{-- pupuk --}}
        <form action="{{ route('addPupuk') }}" method="post">
            @csrf
            <div class="modal fade" id="pupuk">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header bg-custome">
                            <h4 class="modal-title">Input Pupuk</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-lg-5 col-7">
                                    <label for=""
                                        style="font-weight: bold; font-family: Arial, Helvetica, sans-serif;">Tanggal</label>
                                    <input type="date" name="tgl" value="<?= date('Y-m-d') ?>" class="form-control">
                                </div>
                                <div class="col-lg-12"></div>
                                <br>
                                <div class="col-lg-5 col-6">
                                    <label for=""
                                        style="font-weight: bold; font-family: Arial, Helvetica, sans-serif;">Kandang</label>
                                    <Select class="form-control select2" name="id_kandang[]">
                                        <option value="">Kandang</option>
                                        @foreach ($kandang as $k)
                                            <option value="{{ $k->id_kandang }}">{{ $k->nm_kandang }}</option>
                                        @endforeach
                                    </Select>
                                </div>

                                <div class="col-lg-5 col-6">
                                    <label for=""
                                        style="font-weight: bold;font-family: Arial, Helvetica, sans-serif;">Karung</label>
                                    <input type="text" name="jumlah[]" class="form-control  ">
                                </div>


                                <div class="col-lg-1 col-2">
                                    <label for=""
                                        style="font-weight: bold;font-family: Arial, Helvetica, sans-serif;">Aksi</label>
                                    <button id="tambah_pupuk" type="button" class="btn btn-primary btn-sm"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div id="detail_pupuk">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bwaves-effect waves-light btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    {{-- -=------------ --}}

    {{-- input telur --}}
        <form action="{{ route('addTelur') }}" method="post">
            @csrf
            <div class="modal fade" id="telur">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-custome">
                            <h4 class="modal-title">Input Telur</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-lg-5 col-7">
                                    <label for=""
                                        style="font-weight: bold; font-family: Arial, Helvetica, sans-serif;">Tanggal</label>
                                    <input type="date" name="tgl" value="<?= date('Y-m-d') ?>" class="form-control">
                                </div>
                                <div class="col-lg-12"></div>
                                <br>
                                <div class="col-lg-3 col-6">
                                    <label for=""
                                        style="font-weight: bold; font-family: Arial, Helvetica, sans-serif;">Kandang</label>
                                    <Select class="form-control select2" name="id_kandang[]">
                                        <option value="">Kandang</option>
                                        @foreach ($kandang as $k)
                                            <option value="{{ $k->id_kandang }}">{{ $k->nm_kandang }}</option>
                                        @endforeach
                                    </Select>
                                </div>

                                @foreach ($jenis as $j)
                                    <input type="hidden" name="id_jenis[]" value="{{ $j->id }}">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Pcs {{ $j->jenis }}</label>
                                            <input type="text" value="0" class="form-control" name="pcs[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Kg {{ $j->jenis }}</label>
                                            <input type="text" value="0" class="form-control" name="kg[]">
                                        </div>
                                    </div>
                                @endforeach
                                {{-- <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Aksi</label><br>
                                        <button class="btn btn-primary" id="tambah_telur" type="button"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                </div> --}}
                            </div>
                            <div id="detail_telur">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bwaves-effect waves-light btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    {{-- ---------------------- --}}

    {{-- edit telur --}}
        <form action="{{ route('editTelur') }}" method="post">
            @csrf
            <div class="modal fade" id="modalEditLayer">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-custome">
                            <h4 class="modal-title">Input Telur</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            
                            <div id="editTelurView">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bwaves-effect waves-light btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    {{-- ---------------------- --}}

    

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            
            
            var c = 1
            tambahPupuk(c)
            tambahTelur(c)
            tambahPopulasi(c)
            tambahPakan(c)
            tambahObatPakan(c)
            tambahObatAir(c)
            hasilLayer()
            editLayer()
            changeKandang()
            changePakan(c)
            keyupPersen()
            keyupPersenEdit()
            changeObat(c)
            changeObatAir(c)
            changeObatAyam()
            viewHistoryPerencanaan()
            viewEditPerencanaan()
            viewHistoryStok()
            viewHistoryPullet()

            function viewHistoryStok() {
                $(document).on("click", '#btnStok', function(){
                    var tgl = $("#tglStok").val();
                    $.ajax({
                        type: "GET",
                        url: "{{route('viewHistoryStok')}}",
                        data: {
                            tgl:tgl,
                        },
                        success: function (r) {
                            $("#hasilStok").html(r);
                        }
                    });
                })

            }

            function viewHistoryPullet() {
                $(document).on("click", '#btnPullet', function(){
                    var tgl1 = $("#tglDariPullet").val();
                    var tgl2 = $("#tglSampaiPullet").val();
                    var id_kandang = $("#id_kandangPullet").val();

                    $.ajax({
                        type: "GET",
                        url: "{{route('viewHistoryPullet')}}",
                        data: {
                            tgl1:tgl1,
                            tgl2:tgl2,
                            id_kandang:id_kandang
                        },
                        success: function (r) {
                            $("#hasilPullet").html(r);
                            
                        }
                    });
                })
            }

            function viewHistoryPerencanaan() {
                $(document).on('click', '#btnPerencanaan', function(){
                    var tgl = $("#tglHistoryPerencanaan").val();
                    var id_kandang = $("#id_kandangPerencanaan").val();
                    
                    $.ajax({
                        type: "GET",
                        url: "{{route('viewHistoryPerencanaan')}}",
                        data: {
                            tgl:tgl,
                            id_kandang:id_kandang
                        },
                        success: function (r) {
                            $("#hasilPerencanaan").html(r);
                            $('.select2').select2()
                        }
                    });
                })
            }

            function viewEditPerencanaan() {
                $(document).on('click', "#edit_per", function(){
                    var id_kandang = $(this).attr('id_kandang')
                    var tgl = $(this).attr('tgl')

                    $.ajax({
                        type: "GET",
                        url: "{{route('viewHistoryEditPerencanaan')}}",
                        data: {
                            id_kandang:id_kandang,
                            tgl:tgl,
                        },
                        success: function (r) {
                            $('#hasilEditPerencanaan').html(r)
                            $('.select2').select2()
                        }
                    });
                })
            }

            function hasilLayer() {
                $(document).on('click', '#btnLayer', function(){
                    var tgl = $("#tglLayer").val();
                  
                    $.ajax({
                        type: "GET",
                        url: "{{route('hasilLayer')}}?tgl="+tgl,
                        success: function (data) {
                            $("#hasilLayer").html(data);
                            $('.select2').select2()
                        }
                    });
                })
            }
          
            function editLayer() {
                $(document).on('click', '#editLayer', function(){
                    var nota = $(this).attr('nota');
                    var tgl = $("#tglLayer").val();
                   
                    $.ajax({
                        type: "GET",
                        url: "{{route('editLayer')}}",
                        data: {
                            nota : nota,
                            tgl : tgl
                        },
                        success: function (response) {
                            $("#editTelurView").html(response);
                            $('.select2').select2()
                        }
                    });
                })
            }

            function tambahPupuk(c) {
                $(document).on('click', '#tambah_pupuk', function() {
                    c += 1
                    $.ajax({
                        type: "GET",
                        url: "{{ route('tambah_pupuk') }}?c=" + c,
                        success: function(data) {
                            $("#detail_pupuk").append(data);
                            $('.select2').select2()
                        }
                    });
                })

                $(document).on('click', '.removePupuk', function() {
                    var delete_row = $(this).attr("count");
                    $('#row' + delete_row).remove();
                })
            }

            function tambahTelur(c) {
                $(document).on('click', '#tambah_telur', function() {

                    c += 1
                    $.ajax({
                        type: "GET",
                        url: "{{ route('tambah_telur') }}?c=" + c,
                        success: function(data) {
                            $("#detail_telur").append(data);
                            $('.select2').select2()
                        }
                    });
                })

                $(document).on('click', '.removeTelur', function() {
                    var delete_row = $(this).attr("count");
                    $('#row' + delete_row).remove();
                })
            }

            function tambahPopulasi(c) {
                $(document).on('click', '#tambah_populasi', function() {

                    c += 1
                    $.ajax({
                        type: "GET",
                        url: "{{ route('tambah_populasi') }}?c=" + c,
                        success: function(data) {
                            $("#detail_populasi").append(data);
                            $('.select2').select2()
                        }
                    });
                })

                $(document).on('click', '.removePopulasi', function() {
                    var delete_row = $(this).attr("count");
                    $('#row' + delete_row).remove();
                })
            }

            function tambahPakan(c) {
                $(document).on('click', '#tbhPakan', function () {
                    c += 1
                    $.ajax({
                        type: "GET",
                        url: "{{ route('tambah_pakan') }}?c=" + c,
                        success: function(data) {
                            $("#detail_pakan").append(data);
                            $('.select2').select2()
                        }
                    });
                });

                $(document).on('click', '.removePakan', function() {
                    var delete_row = $(this).attr("count");
                    $('#rowPakan' + delete_row).remove();
                })
            }

            function tambahObatPakan(c) {
                $(document).on('click', '#tbhObatPakan', function () {
                    c += 1
                    $.ajax({
                        type: "GET",
                        url: "{{ route('tambah_obatPakan') }}?c=" + c,
                        success: function(data) {
                            $("#detail_obatPakan").append(data);
                            $('.select2').select2()
                        }
                    });
                });

                $(document).on('click', '.removeObatPakan', function() {
                    var delete_row = $(this).attr("count");
                    $('#rowObatPakan' + delete_row).remove();
                })
            }

            function tambahObatAir(c) {
                $(document).on('click', '#tbhObatAir', function () {
                    c += 1
                    $.ajax({
                        type: "GET",
                        url: "{{ route('tambah_obatAir') }}?c=" + c,
                        success: function(data) {
                            $("#detail_obatAir").append(data);
                            $('.select2').select2()
                        }
                    });
                });

                $(document).on('click', '.removeObatAir', function() {
                    var delete_row = $(this).attr("count");
                    $('#rowAir' + delete_row).remove();
                })
            }

            function changeKandang() {
                $("#kandangPerencanaan").change(function (e) { 
                    var id_kandang = $(this).val()
                    var tgl = $("#tglPerencanaan").val();
    
                    $.ajax({
                        type: "GET",
                        url: "{{route('getPopulasi')}}",
                        data: {
                            id_kandang : id_kandang,
                            tgl : tgl,
                        },
                        success: function (r) {
                                if(r == 'tidak ada data') {
                                    // $('#kgPakanBox').attr('disabled', 'true');
                                    $('.pakan_input').attr('disabled', 'true');
                                    $("#getPopulasi").val(r);
                                } else {
                                    $('.pakan_input').removeAttr('disabled');
                                    // $('#kgPakanBox').removeAttr('disabled');
                                    $("#getPopulasi").val(r);
                                }
                        }
                    });
    
                    $.ajax({
                        type: "GET",
                        url: "{{route('getPakan')}}",
                        data: {
                            id_kandang : id_kandang,
                            tgl : tgl,
                        },
                        success: function (rp) {
                            
                            if(rp == 'Y') {
                                $('.pakan_input').attr('disabled', 'true');
                            }
                        }
                    });
                });
            }

            function changePakan(c) {
                $(document).on('change', '.persen_pakan', function(){
                    c += 1
                    var persen_pakan = $(this).val();
                    var id_kandang = $("#kandangPerencanaan").val();
                    var persen = $(this).attr('persen');

                    $.ajax({
                        type: "GET",
                        url: "{{route('getPersen')}}",
                        data: {
                            id_pakan: persen_pakan,
                            id_kandang: id_kandang,
                            c:c,
                        },
                        success: function (r) {
                            
                            $('#prsn' + persen).val(r)
                            var prsn = $('#prsn' + persen).val(r)
                            var pop = $("#akhir").val();
                            var gr = $("#gr").val();
                            var krng = $("#krng").val();
                            var hasil = (parseFloat(prsn) * parseFloat(gr) * parseFloat(pop)) / 100;
                            $("#hasil" + persen).val(hasil);
                            
                            var total = 0

                            $(".hasil").each(function() {
                                total += parseFloat($(this).val());
                            });

                            var kg = Math.floor(parseFloat(total) / (parseFloat(krng) * 1000));
                            console.log(number);
                            $('#total').val(total);
                            $('#krng_f').val(kg);
                            var krng_f = $("#krng_f").val();
                            var kg_sisa = ((parseFloat(total) / (parseFloat(krng) * 1000)) - parseFloat(krng_f)) * 10;
                        
                            var number = kg_sisa.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                            $('#krng_s').val(number);
                            
                        }
                    });
                })
            }

            function keyupPersen() {
                $(document).on('keyup', '.persen', function(){
                    var detail = $(this).attr('kd');
                    var persen = $(this).val();
                    var pop = $("#getPopulasi").val();
                    var gr = $("#gr").val();
                    // alert(`${detail} - ${persen} - ${pop} - ${gr}`)
                    var krng = $("#krng").val();


                    var hasil = (parseFloat(persen) * parseFloat(gr) * parseFloat(pop)) / 100;
                    // alert(hasil);

                    $("#hasil" + detail).val(hasil);

                    var total = 0;
                    $(".hasil").each(function() {
                        total += parseFloat($(this).val());
                    });
                    // var kg = parseFloat(total) / (parseFloat(krng) * 1000)
                    var kg = Math.floor(parseFloat(total) / (parseFloat(krng) * 1000));

 
                    $('#total').val(total);
                    $('#krng_f').val(kg);
                    var krng_f = $("#krng_f").val();
                    var kg_sisa = ((parseFloat(total) / (parseFloat(krng) * 1000)) - parseFloat(krng_f)) * 10;
                    var number = kg_sisa.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    $('#krng_s').val(number);
                })
            }

            function keyupPersenEdit() {
                $(document).on('keyup', '.persenEdit', function(){
                    var detail = $(this).attr('kd');
                    var persen = $(this).val();
                    var pop = $("#getPopulasiEdit").val();
                    var gr = $("#grEdit").val();
                    // alert(`${detail} - ${persen} - ${pop} - ${gr}`)
                    var krng = $("#krngEdit").val();


                    var hasil = (parseFloat(persen) * parseFloat(gr) * parseFloat(pop)) / 100;
                    // alert(hasil);

                    $("#hasilEdit" + detail).val(hasil);

                    var total = 0;
                    $(".hasilEdit").each(function() {
                        total += parseFloat($(this).val());
                    });
                    // var kg = parseFloat(total) / (parseFloat(krng) * 1000)
                    var kg = Math.floor(parseFloat(total) / (parseFloat(krng) * 1000));

 
                    $('#totalEdit').val(total);
                    $('#krng_fEdit').val(kg);
                    var krng_f = $("#krng_fEdit").val();
                    var kg_sisa = ((parseFloat(total) / (parseFloat(krng) * 1000)) - parseFloat(krng_f)) * 10;
                    var number = kg_sisa.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    $('#krng_sEdit').val(number);
                })
                    
            }

            function changeObat(c) {
                $(document).on('change', '.id_obat_pkn', function(){
                    var id_obat_pkn = $(this).val();
                    var detail = $(this).attr('detail');
                   
                    $.ajax({
                        type: "GET",
                        url: "{{route('getSatuanPakan')}}",
                        data: {
                            id_obat_pakan:id_obat_pkn
                        },
                        dataType: "json",
                        success: function (r) {
                            // alert(detail)
                            $('#ds' + detail).val(r['dosis']);
                            $('#stn' + detail).val(r['satuan']);
                            $('#cmpr' + detail).val(r['campuran']);
                            $('#stnc' + detail).val(r['satuan2']);
                        }
                    });
                }) 
            }

            function changeObatAir() {
                $(document).on('change', '.id_obat_air', function(){
                    var id_obat_air = $(this).val();
                    var detail = $(this).attr('detail');
                   
                    $.ajax({
                        type: "GET",
                        url: "{{route('getSatuanAir')}}",
                        data: {
                            id_obat_pakan:id_obat_air
                        },
                        dataType: "json",
                        success: function (r) {
                       
                            $('#stnAir' + detail).val(r['satuan']);
                            $('#stncAir' + detail).val(r['satuan2']);
                        }
                    });
                }) 
            }

            function changeObatAyam() {
                $(document).on("change", '#obatAyam', function(){
                    var id_obat = $(this).val()
                    $.ajax({
                        type: "GET",
                        url: "{{route('getSatuanObatAyam')}}?id_obat="+id_obat,
                        success: function (r) {
                            $("#satuanObatAyam").val(r);
                        }
                    });
                })
            }
            
        });
    </script>
@endsection
