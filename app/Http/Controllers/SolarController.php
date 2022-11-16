<?php

namespace App\Http\Controllers;

use App\Models\AssetUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SolarController extends Controller
{
    public function solar(Request $r)
    {
        $tgl1 = $r->tgl1 ?? date('Y-m-01');
        $tgl2 = $r->tgl2 ?? date('Y-m-d');

        $data = [
            'title' => 'Solar',
            'solar' => AssetUmum::where('id_akun', 27)->whereBetween('tgl', [$tgl1, $tgl2])->get(),
            'stokSolar' => DB::selectOne("SELECT sum(a.debit) as debit , sum(a.kredit) as kredit FROM tb_asset_umum as a 
                                where a.id_akun = '27' ")
        ];
        return view('solar.solar',$data);
    }

    public function addSolar(Request $r)
    {
        $nota = DB::selectOne("SELECT max(a.no_nota) as nota FROM tb_asset_umum as a");
        $nota2 = empty($nota->nota) ? '1001' : $nota->nota+1;
        $tgl = $r->tgl;
        $data = [
            'id_akun' => 27,
            'tgl' => $tgl,
            'debit' => 0,
            'kredit' => $r->kredit,
            'no_nota' => "SLR-$nota2",
            'disesuaikan' => 'T',
            'ket' => $r->ket,
            'admin' => Auth::user()->name,
        ];
        AssetUmum::insert($data);

        $hargaSatuan = DB::selectOne("SELECT sum(a.qty) as qty, sum(a.debit) as debit 
        FROM tb_jurnal as a 
        where a.id_akun = '27' AND a.debit != 0 
        ORDER BY a.id_jurnal DESC LIMIT 1");

        $kredit = $r->kredit * ($hargaSatuan->debit / $hargaSatuan->qty);

        $data_metode = [
            'id_buku' => 3,
            'id_akun' => '27',
            'no_nota' => 'SLR-' . $nota,
            'urutan' => $nota,
            'kredit' => $kredit,
            'qty' => $r->kredit,
            'tgl' => $tgl,
            'ket' => 'Pengambilan solar',
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->insert($data_metode);

        $data_debit = [
            'id_buku' => 3,
            'id_akun' => '28',
            'no_nota' => 'SLR-' . $nota,
            'urutan' => $nota,
            'debit' => $kredit,
            'tgl' => $tgl,
            'ket' => 'Pengambilan solar',
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->insert($data_debit);

        return redirect()->route('solar')->with('sukses', "Data berhasil ditambahkan");
    }

    public function editModalSolar(Request $r)
    {
        return view('solar.modal',[
            'solar' => AssetUmum::where('id_asset', $r->id_asset)->first(),
        ]);
    }

    public function editSolar(Request $r)
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
        where a.id_akun = '27' AND a.debit != 0 
        ORDER BY a.id_jurnal DESC LIMIT 1");

        $kredit = $r->kredit * ($hargaSatuan->debit / $hargaSatuan->qty);
        $data_metode = [
            'kredit' => $kredit,
            'tgl' => $tgl,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->where([['no_nota', $r->no_nota],['id_akun', 27]])->update($data_metode);

        $data_debit = [
            'debit' => $kredit,
            'tgl' => $tgl,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_jurnal')->where([['no_nota', $r->no_nota],['id_akun', 28]])->update($data_debit);

        return redirect()->route('solar')->with('sukses', 'Data berhasil diubah');
    }

    public function deleteSolar($id)
    {
        $cekStok = DB::select("SELECT * FROM `tb_jurnal` as a
        LEFT JOIN tb_asset_umum as b ON a.no_nota = b.no_nota
        WHERE b.no_nota = '$id' AND a.penutup = 'Y'");
 
        $tipe = !empty($cekStok) ? 'error' : 'sukses';
        $pesan = !empty($cekStok) ? "Solar Sudah Di tutup" : "Data berhasil dihapus";

        if($tipe == 'error') {
            return redirect()->route('solar')->with($tipe, $pesan);
        } else {
            DB::table('tb_asset_umum')->where('no_nota', $id)->delete();
            DB::table('tb_jurnal')->where('no_nota', $id)->delete();
            return redirect()->route('solar')->with($tipe, $pesan);
        }

        
    }
}
