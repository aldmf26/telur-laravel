<div>
    <div class="modal-header">
        <h5 class="modal-title">tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <label for="">Tanggal</label>
                <input type="date" class="form-control @error('tgl') is-invalid @enderror" wire:model="tgl">
                @error('tgl')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="">Bawa</label>
                <input type="text" class="form-control @error('tgl') is-invalid @enderror" wire:model="bawa">
                @error('bawa')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="">Pcs</label>
                <input wire:model="pcs.0" type="number" class="form-control @error('pcs.0') is-invalid @enderror">
                @error('pcs.0')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="">Kg</label>
                <input wire:model="kg.0" type="number" class="form-control @error('kg.0') is-invalid @enderror">
                @error('kg.0')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Jenis</label>
                <div wire:ignore>
                    <select data-pharaonic="select2" data-component-id="{{ $this->id }}" wire:model="selJenis.0"
                        class="form-control @error('selJenis.0') is-invalid @enderror" style="width: 100%">
                        <option value="">- Pilih Jenis -</option>
                        @foreach ($jenis as $j)
                            <option value="{{ $j->id }}">{{ $j->jenis }}</option>
                        @endforeach
                    </select>
                    @error('selJenis.0')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-1">
                <label for="">Aksi</label>
                <button wire:click.prevent="add({{ $i }})" class="btn btn-primary btn-sm"><i
                        class="fa fa-plus"></i></button>
            </div>
        </div>
        @foreach ($inputs as $index => $v)
            <div class="row mt-3 mb-2">
                <div class="col-md-4">
                    <input wire:model="pcs.{{ $v }}" placeholder="Pcs.." type="text" class="form-control">

                </div>
                <div class="col-md-4">
                    <input wire:model="kg.{{ $v }}" placeholder="Kg.." type="text" class="form-control">
                </div>
                <div class="col-md-3">
                    <div wire:ignore>
                        <select data-pharaonic="select2" data-component-id="{{ $this->id . $v }}"
                            wire:model="selJenis.{{ $v }}" class="form-control select2" style="width: 100%">
                            <option value="">- Pilih Jenis -</option>
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id }}">{{ $j->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <button wire:click.prevent="remove({{ $index }})" class="btn btn-danger btn-sm"><i
                            class="fa fa-minus"></i></button>
                </div>
            </div>
        @endforeach

    </div>
    <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button wire:click="save" type="button" class="btn btn-primary">Save changes</button>
    </div>
    {{-- <script>
        // Init Event
        $this->dispatchBrowserEvent('pharaonic.select2.init');

        // Load Event
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'component' => $this->id,
            'target' => '#input-here'
        ]);
    </script> --}}
</div>
