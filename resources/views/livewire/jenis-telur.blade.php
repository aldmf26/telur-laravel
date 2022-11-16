<div>


    <form wire:submit.prevent="saveJenis">
        <div class="modal-header">
            <h5 class="modal-title">Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @include('layouts.alert')
            <div class="row">
                <div class="col-lg-12">
                    <label for="">Jenis Telur</label>
                    <input type="text" autofocus wire:model="jenis" class="form-control">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <table class="table" width="100%" id="table2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($telur as $no => $t)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $t->jenis }}</td>
                                    <td>
                                        <button type="button" wire:click="edit({{ $t->id }})"
                                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>
                                        <button type="button" wire:click="delete({{ $t->id }})"
                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>
