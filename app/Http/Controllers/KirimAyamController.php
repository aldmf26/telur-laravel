<?php

namespace App\Http\Controllers;

use App\Models\Kirim_ayam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KirimAyamController extends Controller
{
    public function index(Request $r)
    {

        $tgl1 = !$r->tgl1 ? date('Y-m-01') : $r->tgl1;
        $tgl2 = !$r->tgl2 ? date('Y-m-d') : $r->tgl2;
        
        $ayam = Kirim_ayam::whereBetween('tgl', [$tgl1, $tgl2])->get();
        $data = [
            'title' => 'Kirim ayam',
            'kirimAyam' => $ayam,
        ];

        return view('kirimAyam.index', $data);
    }

    public function editModalAyam(Request $r)
    {
        $ayam = Kirim_ayam::find($r->id);
        return view('kirimAyam.modal', ['ayam' => $ayam]);
    }

    public function tambahAyam(Request $r)
    {
        
        $nota = DB::selectOne("SELECT max(a.no_nota) as nota FROM kirim_ayams as a");
        $nota2 = empty($nota->nota) ? '1001' : $nota->nota+1;

        Kirim_ayam::create([
            'tgl' => $r->tgl,
            'bawa' => $r->bawa,
            'qty' => $r->qty,
            'nota' => $nota2,
            'kode' => $r->jenis == 'pemutihan' ? 'PA' : 'KA',
            'check' => 'T',
            'pemutihan' => 'T',
            'admin' => Auth::user()->name,
        ]);
        return redirect()->route('kirimAyam')->with('sukses', 'Data berhasil ditambah');
    }

    public function editAyam(Request $r)
    {
        Kirim_ayam::where('id', $r->id)->update([
            'tgl' => $r->tgl,
            'bawa' => $r->bawa,
            'qty' => $r->qty,
            'kode' => $r->qty,
            'admin' => Auth::user()->name,
        ]);
        return redirect()->route('kirimAyam')->with('sukses', 'Data berhasil diedit');
    }

    public function deleteAyam($id)
    {
        Kirim_ayam::where('id', $id)->delete();
        return redirect()->route('kirimAyam')->with('sukses', 'Data berhasil dihapus');
    }
}
