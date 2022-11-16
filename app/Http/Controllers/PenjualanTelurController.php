<?php

namespace App\Http\Controllers;

use App\Models\PenjualanTelur;
use App\Models\Telur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanTelurController extends Controller
{
    public function index(Request $r)
    {
        $tgl1 = !$r->tgl1 ? date('Y-m-01') : $r->tgl1;
        $tgl2 = !$r->tgl2 ? date('Y-m-d') : $r->tgl2;

        // $ayam = Kirim_ayam::whereBetween('tgl', [$tgl1, $tgl2])->get();
        $data = [
            'title' => 'Penjualan Telur',
            'telur' => DB::table('tb_jenis_telur')->get(),
            'jenis' => DB::table('tb_jenis_telur')->get(),
            'penjualan' => DB::select("SELECT * FROM `tb_penjualan_telur` as a
            where a.tgl BETWEEN '$tgl1' AND '$tgl2'
            GROUP BY a.nota;"),
        ];

        return view('penjualanTelur.index', $data);
    }

    public function viewDetail(Request $r)
    {
        $no_nota = $r->no_nota;
        $penjualan = PenjualanTelur::where('no_nota', $no_nota)->first();
        $jenis = DB::table('tb_jenis_telur')->get();
        // dd($penjualan);
        return view('penjualanTelur.detailView', ['penjualan' => $penjualan, 'jenis' => $jenis]);
    }

    public function addPenjualan(Request $r)
    {
        $nota = DB::selectOne("SELECT max(a.nota) as nota FROM tb_penjualan_telur as a");
        $nota2 = empty($nota->nota) ? '1001' : $nota->nota+1;

        for ($i = 0; $i < count($r->pcs); $i++) {

            $data = [
                'tgl' => $r->tgl,
                'bawa' => $r->bawa,
                'admin' => Auth::user()->name,
                'nota' => $nota2,
                'pcs' => $r->pcs[$i],
                'kg' => $r->kg[$i],
                'id_jenis' => $r->id_jenis[$i],
                'check' => 'T'
            ];
            Telur::create($data);
        }


        return redirect()->route('penjualanTelur')->with('sukses', 'Data Berhasil ditambahkan');
    }

    public function editModalPenjualan(Request $r)
    {
        return view('penjualanTelur.modal', [
            'penjualan' =>  DB::selectOne("SELECT * FROM `tb_penjualan_telur` as a
            where a.nota = '$r->nota'
            GROUP BY a.nota;"),
            'jenis' => DB::table('tb_jenis_telur')->get(),
        ]);
    }

    public function editPenjualan(Request $r)
    {
        for ($i = 0; $i < count($r->pcs); $i++) {

            $data = [
                'tgl' => $r->tgl,
                'bawa' => $r->bawa,
                'admin' => Auth::user()->name,
                'pcs' => $r->pcs[$i],
                'kg' => $r->kg[$i],
            ];
            Telur::where('id_penjualan', $r->id_penjualan[$i])->update($data);
        }
        return redirect()->route('penjualanTelur')->with('sukses', "Data berhasil diubah");
    }

    public function pemutihanPenjualan(Request $r)
    {
        $nota = DB::selectOne("SELECT max(a.nota) as nota FROM tb_penjualan_telur as a");
        $nota2 = empty($nota->nota) ? '1001' : $nota->nota+1;

        for ($i = 0; $i < count($r->pcs); $i++) {

            $data = [
                'tgl' => $r->tgl,
                'bawa' => $r->bawa,
                'admin' => Auth::user()->name,
                'nota' => $nota2,
                'pcs' => $r->pcs[$i],
                'kg' => $r->kg[$i],
                'id_jenis' => $r->id_jenis[$i],
                'check' => 'T'
            ];
            Telur::create($data);
        }
        return redirect()->route('penjualanTelur')->with('sukses', "Data berhasil pemutihan");
    }

    public function deletePenjualan($id)
    {
        Telur::where('nota', $id)->delete();
        return redirect()->route('penjualanTelur')->with('sukses', "Data berhasil dihapus");
    }
}
