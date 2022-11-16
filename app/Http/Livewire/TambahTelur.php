<?php

namespace App\Http\Livewire;

use App\Models\PenjualanTelur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TambahTelur extends Component
{
    public $selJenis, $kg, $pcs, $tgl, $bawa;
    public $inputs = [];
    public $i = 1;
    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function resetInput()
    {
        $this->selJenis = '';
        $this->kg = '';
        $this->pcs = '';
        $this->tgl = '';
        $this->nama = '';
    }

    public function save()
    {
     
        $this->validate([
            'tgl' => 'required',
            'bawa' => 'required',
            'kg.0' => 'required|numeric',
            'pcs.0' => 'required|numeric',
            'selJenis' => 'required'
        ]);
        $nota = DB::select("SELECT * FROM tb_penjualan GROUP BY no_nota");
        $no_nota = 1000+(count($nota)+1);
        foreach($this->pcs as $v => $i) {
            // dd($this->selJenis[$v]);
            $data = [
                'no_nota' => $no_nota,
                'tgl' => $this->tgl,
                'bawa' => $this->bawa,
                'pcs' => $this->pcs[$v],
                'kg' => $this->kg[$v],
                'id_jenis' => $this->selJenis[$v],
                'admin' => Auth::user()->name
            ];
    
            PenjualanTelur::create($data);
        }
        $this->inputs = [];

        $this->resetInput();
        session()->flash('sukses', 'Berhasil tambah penjualan.');
        $this->emit('tambahPenjualan');
        $this->dispatchBrowserEvent('close-modal');
        // $this->redirect('penjualanTelur');
    }

    public function render()
    {

        return view('livewire.tambah-telur', ['jenis' => DB::table('tb_jenis_telur')->get()]);
    }
}
