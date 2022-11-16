<?php

namespace App\Http\Livewire\Layer;

use Livewire\Component;

class TableLayer extends Component
{
    public function render()
    {
        return view('livewire.layer.table-layer');
    }

    public function modalPupuk()
    {
        $this->dispatchBrowserEvent('show-pupuk');
    }
}
