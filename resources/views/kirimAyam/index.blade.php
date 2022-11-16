@extends('layouts.app')

@section('content')
    <section class="section">
        {{-- <div class="section-header">
            <h3 class="page__heading">Dashboard</h3>
        </div> --}}
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="float-right">Pengiriman Ayam</h4>
                            <div class="card-header-action">
                                <button data-target="#view" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-eye"></i> View</button>
                                <button data-target="#pemutihan" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus"></i>
                                    Pemutihan</button>
                                <button data-target="#tambahan" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus"></i> Tambah
                                    Data</button>

                            </div>
                        </div>
                        <div class="card-body">
                            @include('layouts.alert')
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>Tanggal</th>
                                        <th>Nota</th>
                                        <th>Bawa</th>
                                        <th>Ekor</th>
                                        <th>Admin</th>
                                        <th>Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kirimAyam as $no => $i)
                                        <tr>
                                            <td class="text-center">
                                                {{ $no + 1 }}
                                            </td>
                                            <td>{{ $i->tgl }}</td>
                                            <td>
                                                {{ $i->kode.'-'.$i->nota }}
                                            </td>
                                            <td>{{ $i->bawa }}</td>
                                            <td>{{ $i->qty }}</td>
                                            <td>Aldi</td>
                                            <td>
                                                <button data-target="#edit" data-toggle="modal" type="button" id="btnEdit" id_ayam="{{ $i->id }}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                                <a href="{{ route('deleteAyam', $i->id) }}" onclick="return confirm('Yakin dihapus ? ')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Dashboard Content</h3>
                        </div>
                    </div>
                </div>
            </div> --}}
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
    <form action="{{ route('tambahAyam') }}" method="post">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="tambahan">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Tanggal</label>
                                <input type="date" class="form-control" name="tgl">
                            </div>
                            <div class="col-md-4">
                                <label for="">Bawa</label>
                                <input type="text" class="form-control" name="bawa">
                            </div>
                            <div class="col-md-4">
                                <label for="">Ekor</label>
                                <input type="text" class="form-control" name="qty">
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

    {{-- pemutihan --}}
    <form action="{{ route('tambahAyam') }}" method="POST">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="pemutihan">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pemutihan Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" name="jenis" value="pemutihan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Tanggal</label>
                                <input type="date" class="form-control" name="tgl">
                            </div>
                            <div class="col-md-6">
                                <label for="">Ekor</label>
                                <input type="text" class="form-control" name="qty">
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

    {{-- edit data --}}
    <form action="{{ route('editAyam') }}" method="POST">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="edit">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
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
    $(document).ready(function () {
        $(document).on('click', '#btnEdit', function(){
            var id_ayam = $(this).attr('id_ayam')
            // $("#modalEdit").load("{{route('editModalAyam')}}?id="+id_ayam, "data", function (response, status, request) {
            //     this; // dom element
                
            // });
            $.ajax({
                method: "GET",
                url: "{{route('editModalAyam')}}?id="+id_ayam,
                success: function (data) {
                    $("#modalEdit").html(data);
                }
            });
        })
        // $("#btnEdit").click(function (e) { 
            
        // });
    });
</script>
@endsection
