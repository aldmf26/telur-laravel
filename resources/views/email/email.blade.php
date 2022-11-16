@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Data Email Laporan Telur</h4>
                            <div class="card-header-action">
                                <button data-target="#tambahan" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus"></i> Tambah
                                    Data</button>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('layouts.alert')
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($email as $no => $e)
                                        <tr>
                                            <td>{{ $no + 1 }}</td>
                                            <td>{{ $e->email }}</td>
                                            <td>
                                                <button type="button" data-target="#ubah" data-toggle="modal" id="btnEdit"
                                                    id_email="{{ $e->id_email }}" class="btn btn-warning btn-sm"><i
                                                        class="fa fa-edit"></i></button>
                                                <a href="{{ route('deleteEmail', $e->id_email) }}"
                                                    onclick="return confirm('Apakah yaking dihapus ?')"
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
    <form action="{{ route('addEmail') }}" method="post">
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
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input autofocus required type="email" class="form-control" name="email">
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
    <form action="{{ route('editEmail') }}" method="post">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="ubah">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_email" id="email_id">
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
                var id_email = $(this).attr('id_email')
                $("#email_id").val(id_email);
                $.ajax({
                    method: "GET",
                    url: "{{ route('editModalEmail') }}?id_email=" + id_email,
                    success: function(data) {
                        $("#modalEdit").html(data);
                    }
                });
            })
        });
    </script>
@endsection
