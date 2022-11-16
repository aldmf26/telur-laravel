<?php

namespace App\Http\Controllers;

use App\Models\Performa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerformaController extends Controller
{
    public function index($kategori)
    {
        $data = [
            'title' => 'Performa',
            'kategori' => $kategori,
            'strain' => DB::table('tb_strain')->where('id_strain',$kategori)->first(),
            'performa' => Performa::where('id_strain', $kategori)->get()
        ];
        return view('performa.performa',$data);
    }

    public function addPerforma(Request $r)
    {
        $data = [
            'umur' => $r->umur,
            'telur' => $r->telur,
            'berat' => $r->berat,
            'feed' => $r->feed,
            'berat_telur' => $r->berat_telur,
            'id_strain' => $r->id_strain,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_performa')->insert($data);

        return redirect()->route('performa',$r->id_strain)->with('sukses', 'Data Performa berhasil ditambah');
    }

    public function editModalPerforma(Request $r)
    {
        return view('performa.modal',['performa' => Performa::where('id_peformance', $r->id_performa)->first()]);
    }

    public function editPerforma(Request $r)
    {
        $data = [
            'umur' => $r->umur,
            'telur' => $r->telur,
            'berat' => $r->berat,
            'feed' => $r->feed,
            'berat_telur' => $r->berat_telur,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_performa')->where('id_peformance', $r->id_performa)->update($data);

        return redirect()->route('performa',$r->kategori)->with('sukses', 'Data Performa berhasil diubah');
    }

    public function deletePerforma($id,$kategori)
    {
        Performa::where('id_peformance', $id)->delete();
        return redirect()->route('performa',$kategori)->with('sukses', 'Data Performa berhasil dihapus');
    }
}
