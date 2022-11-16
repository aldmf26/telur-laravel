<?php

namespace App\Http\Controllers;

use App\Models\AssetUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RakTelurController extends Controller
{
    public function rakTelur(Request $r)
    {
        $tgl1 = $r->tgl1 ?? date('Y-m-01');
        $tgl2 = $r->tgl2 ?? date('Y-m-d');

        $data = [
            'title' => 'Rak Telur',
            'rak' => AssetUmum::where('id_akun', 29)->whereBetween('tgl', [$tgl1, $tgl2])->get(),
            'stokRakTelur' => DB::selectOne("SELECT sum(a.debit) as debit , sum(a.kredit) as kredit FROM tb_asset_umum as a 
                                where a.id_akun = '29' ")
        ];
        return view('rakTelur.rakTelur',$data);
    }

    public function addRakTelur(Request $r)
    {
        $nota = DB::selectOne("SELECT max(a.no_nota) as nota FROM tb_asset_umum as a");
        $nota2 = empty($nota->nota) ? '1001' : $nota->nota+1;
        $tgl = $r->tgl;
        $data = [
            'id_akun' => 29,
            'tgl' => $tgl,
            'debit' => 0,
            'kredit' => $r->kredit,
            'no_nota' => "RKT-$nota2",
            'disesuaikan' => 'T',
            'ket' => $r->ket,
            'admin' => Auth::user()->name,
        ];
        AssetUmum::insert($data);

        $hargaSatuan = DB::selectOne("SELECT sum(a.qty) as qty, sum(a.debit) as debit 
        FROM tb_jurnal as a 
        where a.id_akun = '29' AND a.debit != 0 
        ORDER BY a.id_jurnal DESC LIMIT 1");

        $kredit = $r->kredit * ($hargaSatuan->debit / $hargaSatuan->qty);
        $data_metode = [
            'id_buku' => 3,
            'id_akun' => '29',
            'no_nota' => 'RKT-' . $nota,
            'urutan' => $nota,
            'kredit' => $kredit,
            'tgl' => $tgl,
            'ket' => 'Pengambilan rak telur',
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->insert($data_metode);

        $data_debit = [
            'id_buku' => 3,
            'id_akun' => '30',
            'no_nota' => 'RKT-' . $nota,
            'urutan' => $nota,
            'debit' => $kredit,
            'tgl' => $tgl,
            'ket' => 'Pengambilan rak telur',
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->insert($data_debit);

        return redirect()->route('rakTelur')->with('sukses', "Data berhasil ditambahkan");
    }

    public function editModalRakTelur(Request $r)
    {
        return view('rakTelur.modal',[
            'solar' => AssetUmum::where('id_asset', $r->id_asset)->first(),
        ]);
    }

    public function editRakTelur(Request $r)
    {
        // dd($r->no_nota);
        $tgl = $r->tgl;
        $data = [
            'tgl' => $tgl,
            'kredit' => $r->kredit,
            'ket' => $r->ket,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_asset_umum')->where('id_asset', $r->id_asset)->update($data);
        
        $hargaSatuan = DB::selectOne("SELECT a.qty, a.debit 
        FROM tb_jurnal as a 
        where a.id_akun = '29' AND a.debit != 0 
        ORDER BY a.id_jurnal DESC LIMIT 1");

        $kredit = $r->kredit * ($hargaSatuan->debit / $hargaSatuan->qty);
        $data_metode = [
            'kredit' => $kredit,
            'tgl' => $tgl,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->where([['no_nota', $r->no_nota],['id_akun', 29]])->update($data_metode);

        $data_debit = [
            'debit' => $kredit,
            'tgl' => $tgl,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->where([['no_nota', $r->no_nota],['id_akun', 30]])->update($data_debit);

        return redirect()->route('rakTelur')->with('sukses', 'Data berhasil diubah');
    }

    public function deleteRakTelur($id)
    {
        DB::table('tb_asset_umum')->where('no_nota', $id)->delete();
        DB::table('tb_jurnal')->where('no_nota', $id)->delete();
        return redirect()->route('rakTelur')->with('sukses', "Data berhasil dihapus");
    }
}
