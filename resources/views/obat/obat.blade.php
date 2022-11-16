@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Data Obat</h4>
                            <div class="card-header-action">
                                <a href="{{ route('exportObat',['jenis' => 'obat']) }}"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-download"></i>
                                    Export</a>
                                <button data-target="#import" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-upload"></i>
                                    Import</button>
                                <button data-target="#tambah" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus"></i> Tambah
                                    Data</button>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('layouts.alert')
                            <table class="table table-stripped" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Obat</th>
                                        <th>Jenis</th>
                                        <th>Dosis</th>
                                        <th>Campuran</th>
                                        <th>Kegunaan</th>
                                        <th>Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($obat as $no => $o)
                                    <tr>
                                        <td>{{ $no+1 }}</td>
                                        <td>{{ $o->nm_barang }}</td>
                                        <td>{{ $o->nm_jenis }}</td>
                                        <td>{{ $o->dosis . ' ' . $o->satuan }}</td>
                                        <td>{{ $o->campuran . ' ' . $o->satuan2 }}</td>
                                        <td>{{ $o->kegunaan }}</td>
                                        <td>
                                            <button type="button" data-target="#ubah" data-toggle="modal" id="btnEdit"
                                                id_obat="{{ $o->id_barang }}" class="btn btn-warning btn-sm"><i
                                                    class="fa fa-edit"></i></button>
                                            <a href="{{ route('deleteObat', $o->id_barang) }}" onclick="return confirm('Apakah yaking dihapus ?')"
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

    {{-- tambah data --}}
    <form action="{{ route('addObat') }}" method="post">
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nama Obat</label>
                                    <input type="text" name="nm_obat" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Kegunaan</label>
                                    <input type="text" class="form-control" name="kegunaan">
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
                                            <option value="{{ $j->id_jenis }}">{{ $j->nm_jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Dosis</label>
                                    <input type="text" class="form-control" name="dosis">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Satuan</label>
                                    <select name="satuan" id="" class="form-control select2">
                                        <option value="">Satuan</option>
                                        @foreach ($satuan as $s)
                                            <option value="{{ $s->id_satuan }}">{{ $s->nm_satuan }}</option>
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
                                            <option value="{{ $sa->id_satuan }}">{{ $sa->nm_satuan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Campuran</label>
                                    <input type="text" class="form-control" name="campuran">
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
    <form action="{{ route('editObat') }}" method="post">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="ubah">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
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
    
@endsection
@section('scripts')
<script>
    $(document).on('click', '#btnEdit', function(){
            var id_obat = $(this).attr('id_obat')
          
            $.ajax({
                method: "GET",
                url: "{{route('editModalObat')}}?id_obat="+id_obat,
                success: function (data) {
                    $("#modalEdit").html(data);
                    $('.select2').select2()
                }
            });
        })
</script>
@endsection
