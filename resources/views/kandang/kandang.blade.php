@extends('layouts.app')
@section('content')
    <section class="section"> 
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    {{-- <div class="card card-primary">
                        <div class="card-header">
                            <h4>Input Kandang</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-primary">
                                        <th>Date Check-in</th>
                                        <th>Kandang</th>
                                        <th>Strain</th>
                                        <th>Ayam Awal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <form action="{{ route('addKandang') }}" method="post">
                                    @csrf
                                <tbody class="table-info">
                                    <tr>
                                        <td><input required type="date" value="{{ date('Y-m-d') }}" class="form-control" name="tgl_masuk"></td>
                                        <td><input required type="text" class="form-control" name="nm_kandang"></td>
                                        <td>
                                            <select name="id_strain" class="form-control select2">
                                                <option value="">Strain</option>
                                                @foreach ($strain as $s)
                                                    <option value="{{ $s->id_strain }}">{{ $s->nm_strain }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="ayam_awal"></td>
                                        <td><button class="btn btn-sm btn-primary" type="submit">Save</button></td>
                                    </tr>
                                </tbody>
                            </form>
                            </table>
                        </div>
                    </div> --}}
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Data Kandang</h4>
                            <div class="card-header-action">
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
                                        <th>Date Check-in</th>
                                        <th>Kandang</th>
                                        <th>Strain</th>
                                        <th>Jumlah Ayam Awal</th>
                                        <th>Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kandang as $no => $k)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <td>{{ $k->tgl_masuk }}</td>
                                            <td>{{ $k->nm_kandang }}</td>
                                            <td>{{ $k->nm_strain }}</td>
                                            <td>{{ $k->ayam_awal }}</td>
                                            <td>
                                                @if ($k->selesai == 'Y')
                                                    <a href="{{ route('status', ['belum', $k->id_kandang]) }}" class="btn btn-sm btn-success"><i class="fa fa-check"></i> </a>
                                                @else
                                                    <a href="{{ route('status', ['selesai', $k->id_kandang]) }}" class="btn btn-sm btn-success"><i class="fa fa-hourglass-half"></i> </a>
                                                @endif
                                                <button type="button" data-target="#ubah" data-toggle="modal" id="btnEdit"
                                                id_kandang="{{ $k->id_kandang }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> </button>
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

    {{-- tambah --}}
    <form action="{{ route('addKandang') }}" method="post">
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
                                    <label for="">Data Check-in</label>
                                    <input required type="date" value="{{ date('Y-m-d') }}" class="form-control" name="tgl_masuk">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Kandang</label>
                                    <input required type="text" class="form-control" name="nm_kandang">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Strain</label>
                                    <select name="id_strain" class="form-control select2">
                                        <option value="">Strain</option>
                                        @foreach ($strain as $s)
                                            <option value="{{ $s->id_strain }}">{{ $s->nm_strain }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Ayam Awal</label>
                                    <input type="text" class="form-control" name="ayam_awal">
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

    {{-- edit --}}
    <form action="{{ route('editKandang') }}" method="post">
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
                        <input type="hidden" name="id_kandang" id="kandang_id">
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
            var id_kandang = $(this).attr('id_kandang')
            $("#kandang_id").val(id_kandang);
            $.ajax({
                method: "GET",
                url: "{{route('editModalKandang')}}?id_kandang="+id_kandang,
                success: function (data) {
                    $("#modalEdit").html(data);
                }
            });
        })
</script>
@endsection