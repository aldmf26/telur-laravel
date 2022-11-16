@extends('layouts.app')
@section('content')
    <section class="section"> 
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                        <h4>Data User</h4>
                        <div class="card-header-action">
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
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                @foreach ($user as $no => $u)
                                    <tr>
                                        <td>{{ $no+1 }}</td>
                                        <td>{{ $u->nama }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td align="center">
                                            <a class="btn btn-{{$u->emailNotif == 'T' ? 'secondary' : 'info'}} btn-sm" href="{{route('emailNotif',[$u->id_user, $u->emailNotif == 'T' ? 'Y' : 'T'])}}"><i class="fa fa-{{$u->emailNotif == 'T' ? 'window-close' : 'envelope'}}"></i></a>
                                            
                                            <button type="button" data-target="#ubah" data-toggle="modal" id="btnEdit"
                                                id_user="{{ $u->id_user }}" class="btn btn-warning btn-sm"><i
                                                    class="fa fa-edit"></i></button>
                                            <a href="{{ route('deleteUser', $u->id_user) }}"
                                                onclick="return confirm('Apakah yaking dihapus ?')"
                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- tambah data --}}
    <form action="{{ route('addUser') }}" method="post">
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
                                    <label for="">Nama</label>
                                    <input autofocus required type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input autofocus required type="email" class="form-control" name="email">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') in-valid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') in-valid @enderror">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <select name="role" id="" class="form-control select2">
                                        <option value="">- Role -</option>
                                        <option value="presiden">Presiden</option>
                                        <option value="admin">Admin</option>
                                    </select>
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
                        <input type="hidden" name="id_user" id="user_id">
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
                var id_user = $(this).attr('id_user')
                $("#user_id").val(id_user);
                $.ajax({
                    method: "GET",
                    url: "{{ route('editModalUser') }}?id_user=" + id_user,
                    success: function(data) {
                        $("#modalEdit").html(data);
                    }
                });
            })
        });
    </script>
@endsection