<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class JenisTelur extends Component
{
    public $jenis,$telur,$tes,$id_delete,$id_edit,$jenis_edit;

    public function render()
    {
        $telur = DB::table('tb_jenis_telur')->get();
        return view('livewire.jenis-telur',[
            'telur' => $this->telur = $telur
        ]);
    }

    public function saveJenis()
    {
     
        DB::table('tb_jenis_telur')->insert([
            'jenis' => $this->jenis
        ]);
        $this->jenis = NULL;
        session()->flash('sukses', 'Jenis telur Berhasil dibuat');
        // $this->dispatchBrowserEvent('close-modal');
    }

    public function editJenis()
    {
      
        DB::table('tb_jenis_telur')->where('id', $this->id_edit)->update([
            'jenis' => $this->jenis_edit
        ]);
        session()->flash('sukses', 'Jenis telur Berhasil diedit');
    }

    public function delete($id)
    {
        $this->id_delete = $id;
        DB::table('tb_jenis_telur')->where('id',$this->id_delete)->delete();
        session()->flash('sukses', 'Jenis telur Berhasil dihapus');
    }
    
    public function edit($id)
    {
        $this->id_edit = $id;
        $n = DB::table('tb_jenis_telur')->find($this->id_edit);
        $this->jenis = $n->jenis;
        $this->jenis_edit = $n->jenis;
    }
}
