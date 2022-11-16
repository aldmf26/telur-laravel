@extends('layouts.app')
@section('content')
    <section class="section"> 
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="float-right">Strain Ayam Petelur</h4>
                            <div class="card-header-action">
                                
                                <button data-target="#summary" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-download"></i>
                                    Summary</button>
                                <button data-target="#tambah" data-toggle="modal" type="button"
                                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus"></i> Tambah
                                    Data</button>

                            </div>
                           
                        </div>
                        <ul class="nav nav-pills nav-secondary" id="custom-tabs-two-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('performa/1') ? 'active' : '' }}"
                                    href="{{ route('performa',1) }}">ISA Brown</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('performa/2') ? 'active' : '' }}"
                                    href="{{ route('performa',2) }}">Lohman Brown</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('performa/3') ? 'active' : '' }}"
                                    href="{{ route('performa',3) }}">Hisex Brown</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('performa/4') ? 'active' : '' }}"
                                    href="{{ route('performa',4) }}">Hyline Brown</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('performa/5') ? 'active' : '' }}"
                                    href="{{ route('performa',5) }}">Novogen Brown</a>
                            </li>
                        </ul>
                        <div class="card-body">
                            @include('layouts.alert')
                            <table class="table table-striped" id="table">
                                <thead class="text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Umur (minggu)</th>
                                        <th>Henday (%)</th>
                                        <th>Berat Badan (g)</th>
                                        <th>Feed Intake (g/ekor/hari)</th>
                                        <th>Berat Telur (g)</th>
                                        <th>Akses</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($performa as $no => $p)
                                    <tr>
                                        <td>{{ $no+1 }}</td>
                                        <td>{{ $p->umur }}</td>
                                        <td>{{ $p->telur }}</td>
                                        <td>{{ $p->berat }}</td>
                                        <td>{{ $p->feed }}</td>
                                        <td>{{ $p->berat_telur }}</td>
                                        <td>
                                            <button type="button" data-target="#ubah" data-toggle="modal" id="btnEdit" id_performa="{{ $p->id_peformance }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
                                            <a href="{{ route('deletePerforma', [$p->id_peformance,$kategori]) }}" onclick="return confirm('Apakah yaking dihapus ?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
    <form action="{{ route('addPerforma') }}" method="post">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="tambah">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">tambah Data {{ $strain->nm_strain }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_strain" value="{{ $kategori }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped table-info">
                                    <tr class="text-dark">
                                        <th>Umur (minggu)</th>
                                        <th>% Telur</th>
                                        <th>Berat Badan (g)</th>
                                        <th>Feed Intake</th>
                                        <th>Berat telur (g)</th>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="umur" class="form-control"></td>
                                        <td><input type="text" name="telur" class="form-control"></td>
                                        <td><input type="text" name="berat" class="form-control"></td>
                                        <td><input type="text" name="feed" class="form-control"></td>
                                        <td><input type="text" name="berat_telur" class="form-control"></td>
                                    </tr>
                                </table>
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
    <form action="{{ route('editPerforma') }}" method="post">
        @csrf
        <div class="modal fade" tabindex="-1" role="dialog" id="ubah">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Data {{ $strain->nm_strain }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" name="kategori" value="{{ $kategori }}">
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
            var id_performa = $(this).attr('id_performa')
          
            $.ajax({
                method: "GET",
                url: "{{route('editModalPerforma')}}?id_performa="+id_performa,
                success: function (data) {
                    $("#modalEdit").html(data);
                }
            });
        })
    });
</script>
@endsection