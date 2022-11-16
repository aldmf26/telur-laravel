<?php

namespace App\Http\Livewire;

use App\Models\PenjualanTelur;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableTelur extends Component
{
    protected $listeners = ['tambahPenjualan' => 'render','hapusPenjualan' => 'render'];
    public $delete_id, $no_nota;
    public bool $loadData = false;

    public function init()
    {
        $this->loadData = true;
    }

    public function mount()
    {
        // $this->redirect('penjualanTelur');
    }

    public function deleteId($id)
    {
        $this->delete_id = $id;
        PenjualanTelur::where('no_nota', $this->delete_id)->delete();
        session()->flash('sukses', 'Penjualan Berhasil dihapus');
        // $this->redirect('penjualanTelur');
        // $this->dispatchBrowserEvent('show-delete');
    }

    public function viewId($id)
    {
        $this->no_nota = $id;
        $this->dispatchBrowserEvent('show-detail');
    }

    // public function deleteAksi()
    // {
       
        
    //     $this->dispatchBrowserEvent('close-modal');
    // }

    public function render()
    {
        $data = [
            'penjualan' => DB::select("SELECT *,SUM(kg) as ttl_kg, SUM(pcs) as ttl_pcs FROM `tb_penjualan` GROUP BY no_nota"),
            'jenis' => DB::table('tb_jenis_telur')->get()
        ];
        return view('livewire.table-telur', $data);
    }
}
