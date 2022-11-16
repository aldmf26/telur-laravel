@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-statistic-1">

                        <div class="card-wrap">
                            <div class="card-header">
                                <h3>Stok Solar : {{number_format($stokSolar->debit - $stokSolar->kredit,0)}} Liter</h4>
                            </div>
                            <div class="card-body mt-3">
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Pengambilan Solar</h4>
                            <div class="card-header-action">
                                <button data-target="#view" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-eye"></i> View</button>
                                <button data-target="#tambah" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus"></i> Tambah
                                    Data</button>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('layouts.alert')
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Nota</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Keterangan</th>
                                        <th>Admin</th>
                                        <th>Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solar as $no => $s)
                                    <tr>
                                        <td>{{ $no+1 }}</td>
                                        <td>{{ $s->tgl }}</td>
                                        <td>{{ $s->no_nota }}</td>
                                        <td>{{ $s->kredit }}</td>
                                        <td>Liter</td>
                                        <td>{{ $s->ket }}</td>
                                        <td>{{ $s->admin }}</td>
                                        <td>
                                            <button type="button" data-target="#ubah" data-toggle="modal" id="btnEdit"
                                                id_asset="{{ $s->id_asset }}" no_nota="{{ $s->no_nota }}" class="btn btn-warning btn-sm"><i
                                                    class="fa fa-edit"></i></button>
                                            <a href="{{ route('deleteSolar', $s->no_nota) }}" onclick="return confirm('Apakah yaking dihapus ?')"
                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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

    {{-- tambah data --}}
    <form action="{{ route('addSolar') }}" method="post">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="tambah">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input required type="date" class="form-control" name="tgl">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Qty</label>
                                    <input required type="text" class="form-control" name="kredit">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <input type="text" class="form-control" name="ket">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Satuan</label>
                                    <input type="text" readonly class="form-control" value="Liter">
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

    {{-- ubah data --}}
    <form action="{{ route('editSolar') }}" method="post">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="ubah">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_asset" id="solar_id">
                        <input type="hidden" name="no_nota" id="solar_nota">
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
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#btnEdit', function() {
                var id_asset = $(this).attr('id_asset')
                $("#solar_id").val(id_asset);
                var no_nota = $(this).attr('no_nota')
                $("#solar_nota").val(no_nota);

                
                $.ajax({
                    method: "GET",
                    url: "{{ route('editModalSolar') }}",
                    data: {
                        id_asset : id_asset,
                        no_nota : no_nota
                    },
                    success: function(d) {
                        $("#modalEdit").html(d);
                    }
                });
            })
        });
    </script>
@endsection
