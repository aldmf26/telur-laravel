<div>
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
                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus"></i> Jenis Telur</button>
                <button data-target="#tambahan" data-toggle="modal" type="button"
                    class="btn btn-sm btn-primary float-right mr-1"><i class="fa fa-plus"></i> Tambah
                    Data</button>

            </div>
        </div>
        <div class="card-body">
            @include('layouts.alert')
            <table class="table table-striped" id="table" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th>Tanggal</th>
                        <th>Nota</th>
                        <th>Bawa</th>
                        {{-- @foreach ($jenis as $j)
                            <th>Pcs {{ ucwords($j->jenis) }}</th>
                            <th>Kg {{ ucwords($j->jenis) }}</th>
                        @endforeach --}}
                        <th>Ttl Ikat</th>
                        <th>Ttl Pcs</th>
                        <th>Ttl Kg</th>
                        <th>Akses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan as $no => $p)
                        <tr>
                            <td>{{ $no + 1 }}</td>
                            <td>{{ $p->tgl }}</td>
                            <td>{{ $p->no_nota }}</td>
                            <td>{{ $p->bawa }}</td>
                            {{-- @foreach ($jenis as $i)
                            @if ($i->id == $p->id_jenis)
                            <td> {{ $p->pcs }} </td>
                            <td> {{ $p->kg }}</td>
                            @else 
                            <td>{{ $i->jenis }} </td>
                            <td>{{ $i->jenis }}</td>
                            @endif
                            @endforeach --}}
                            <td>{{ round($p->ttl_pcs / 180,0) }}</td>
                            <td>{{ $p->ttl_pcs }}</td>
                            <td>{{ $p->ttl_kg }}</td>
                            <td>
                                <button type="button" data-target="#viewDetail" id="detailView" no_nota="{{ $p->no_nota }}" data-toggle="modal" id="btnEdit"
                                    id_ayam="1" class="btn btn-info btn-sm" ><i class="fa fa-eye"></i></button>
                                <button data-target="#edit" data-toggle="modal" type="button" id="btnEdit"
                                    id_ayam="1" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
                                <button type="button" wire:click="deleteId({{ $p->no_nota }})"
                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    {{-- @foreach ($kirimAyam as $no => $i)
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
                    @endforeach --}}

                </tbody>
            </table>
        </div>
    </div>
    {{-- delete form --}}
</div>
