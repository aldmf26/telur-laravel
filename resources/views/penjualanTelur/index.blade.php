@extends('layouts.app')
@section('content')
<style>
    .thSisa {
        white-space: nowrap;
        background-color: #fff;
    }
</style>
    <section class="section">
        {{-- <div class="section-header">
            <h3 class="page__heading">Dashboard</h3>
        </div> --}}
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <table class="" width="100%" border="1">
                        <thead>
                            <tr>
                                <th style="text-align: center; background-color: rgb(189, 238, 217); color: rgb(120, 120, 120);"
                                    colspan="16">Sisa Stock Kandang</th>
                            </tr>
                            <tr>
                                <th width="6%"
                                    style="background-color: rgb(189, 238, 217); color: rgb(120, 120, 120);"></th>
                                @foreach ($jenis as $j)
                                    <th class="thSisa">Pcs {{ ucwords($j->jenis) }}</th>
                                    <th class="thSisa">Kg {{ ucwords($j->jenis) }}</th>
                                    <th class="thSisa">Ikat {{ ucwords($j->jenis) }}</th>
                                @endforeach
                      
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                            <tr>
                                <td>Sisa</td>
                                <!-- Pecah -->
                                @foreach ($jenis as $j)
                                @php
                                    $jenisT = DB::selectOne("SELECT tgl,bawa,sum(pcs) as tPcs, SUM(kg) as tKg FROM `tb_penjualan_telur`
                                                WHERE id_jenis = '$j->id'
                                                GROUP BY id_jenis;");
                                @endphp
                                    <td align="center">{{ round($jenisT->tPcs,1) }}</td>
                                    <td align="center">{{ round($jenisT->tKg,1) }}</td>
                                    <td align="center">{{ number_format($jenisT->tPcs / 180,0) }}</td>
                                @endforeach
                                
                            </tr>
                        </tbody>
                    </table>

                    <hr class="mt-3 mb-2">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="float-right">Penjualan Telur</h4>
                            <div class="card-header-action">
                                <button data-target="#view" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-eye"></i> View</button>
                                <button data-target="#pemutihan" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus"></i>
                                    Pemutihan</button>
                                <button data-target="#jenisTelur" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus"></i> Jenis
                                    Telur</button>
                                <button data-target="#tambahan" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus"></i> Tambah
                                    Data</button>

                            </div>
                        </div>
                        <div class="card-body">
                            @include('layouts.alert')
                            <table class="table table-striped table-responsive" id="table" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>Tanggal</th>
                                        <th>Nota</th>
                                        <th>Bawa</th>
                                        @foreach ($jenis as $j)
                                            <th>Pcs {{ ucwords($j->jenis) }}</th>
                                            <th>Kg {{ ucwords($j->jenis) }}</th>
                                        @endforeach
                                        {{-- <th>Pcs Utuh</th>
                                        <th>Kg Utuh</th>
                                        <th>Pcs Pecah</th>
                                        <th>Kg Pecah</th>
                                        <th>Pcs Putih</th>
                                        <th>Kg Putih</th>
                                        <th>Pcs Tipis</th>
                                        <th>Kg Tipis</th>
                                        <th>Pcs Pupuk</th>
                                        <th>Kg Pupuk</th> --}}
                                        <th>Ttl Ikat</th>
                                        <th>Ttl Pcs</th>
                                        <th>Ttl Kg</th>
                                        <th>Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $ttlPcs = 0;
                                        $ttlKg = 0;
                                        $ttlIkat = 0;
                                        
                                    @endphp
                                    @foreach ($penjualan as $no => $p)
                                        {{-- @php
                                        $ttlPcs = $p->pcs_utuh + $p->pcs_pecah + $p->pcs_putih + $p->pcs_tipis + $p->pcs_pupuk;
                                        $ttlKg = $p->kg_utuh + $p->kg_pecah + $p->kg_putih + $p->kg_tipis + $p->kg_pupuk;
                                        $ttlIkat = $ttlPcs / 180;
                                    @endphp --}}
                                        <tr>
                                            <td>{{ $no + 1 }}</td>
                                            <td>{{ $p->tgl }}</td>
                                            <td>{{ $p->nota }}</td>
                                            <td>{{ $p->bawa }}</td>

                                            @foreach ($jenis as $j)
                                                @php
                                                    $jenisTelur = DB::table('tb_penjualan_telur')
                                                        ->where([['nota', $p->nota], ['id_jenis', $j->id]])
                                                        ->first();
                                                    $ttlPcs += $jenisTelur->pcs;
                                                    $ttlKg += $jenisTelur->kg;
                                                    $ttlIkat = $ttlPcs / 180;
                                                @endphp
                                                <td>{{ $jenisTelur->pcs }}</td>
                                                <td>{{ $jenisTelur->kg }}</td>
                                            @endforeach
                                            {{-- <td>{{ $p->pcs_utuh }}</td>
                                            <td>{{ $p->kg_utuh }}</td>
                                            <td>{{ $p->pcs_pecah }}</td>
                                            <td>{{ $p->kg_pecah }}</td>
                                            <td>{{ $p->pcs_putih }}</td>
                                            <td>{{ $p->kg_putih }}</td>
                                            <td>{{ $p->pcs_tipis }}</td>
                                            <td>{{ $p->kg_tipis }}</td>
                                            <td>{{ $p->pcs_pupuk }}</td>
                                            <td>{{ $p->kg_pupuk }}</td> --}}
                                            <td>{{ number_format($ttlIkat, 0) }}</td>
                                            <td>{{ round($ttlPcs, 1) }}</td>
                                            <td>{{ round($ttlKg, 1) }}</td>
                                            <td>
                                                <button type="button" data-target="#edit" data-toggle="modal"
                                                    id="btnEdit" nota="{{ $p->nota }}"
                                                    class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
                                                <a href="{{ route('deletePenjualan', $p->nota) }}"
                                                    onclick="return confirm('Apakah yaking dihapus ?')"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- @livewire('table-telur') --}}
                </div>
            </div>
        </div>
    </section>

    {{-- view --}}
    <form action="?">
        <div class="modal fade" tabindex="-1" role="dialog" id="view">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Dari</label>
                                <input type="date" class="form-control" name="tgl1">
                            </div>
                            <div class="col-md-6">
                                <label for="">Sampai</label>
                                <input type="date" class="form-control" name="tgl2">
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

    {{-- tambah penjualan --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="tambahan">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {{-- @livewire('tambah-telur') --}}
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('addPenjualan') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- edit data --}}
    <form action="{{ route('editPenjualan') }}" method="POST">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="edit">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" name="id_penjualan" id="penjualan_id">
                    <div class="modal-body">
                        <div id="modalEdit">

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

    {{-- modal jenis telur --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="jenisTelur">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                @livewire('jenis-telur')
            </div>
        </div>
    </div>


    {{-- pemutihan --}}
    <form action="{{ route('pemutihanPenjualan') }}" method="POST">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="pemutihan">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title">Pemutihan Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" name="jenis" value="pemutihan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input required type="date" name="tgl" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Pemutihan</label>
                                    <input required type="text" name="bawa" value="Pemutihan" readonly
                                        class="form-control">
                                </div>
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

    {{-- detail data --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="viewDetail">
        <div class="modal-dialog modal-lg" role="document">
            <div id="getViewDetail"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#btnEdit', function() {
                var nota = $(this).attr('nota')
                // $("#penjualan_id").val(nota);
                $.ajax({
                    method: "GET",
                    url: "{{ route('editModalPenjualan') }}?nota=" + nota,
                    success: function(data) {
                        $("#modalEdit").html(data);
                    }
                });
            })
        });
    </script>
@endsection
