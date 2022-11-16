<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Str;

class LayerController extends Controller
{
    public function index()
    {
        
        $tujuh_hari   = mktime(0, 0, 0, date("n"), date("j") - 1, date("Y"));
        $tglK = date('Y-m-d', $tujuh_hari);
        $tgl = date('Y-m-d');
        $kandang = DB::select("SELECT *,TIMESTAMPDIFF(WEEK, tgl_masuk , '$tgl') AS mgg FROM tb_kandang WHERE selesai = 'T'");
        $jenis = DB::table('tb_jenis_telur')->get();
        $pakan = DB::table('tb_barang_pv')->where('id_jenis', 1)->get();
        $obat = DB::table('tb_barang_pv')->where('id_jenis', 2)->get();
        $obat_air = DB::table('tb_barang_pv')->where('id_jenis', 3)->get();
        $obat_ayam = DB::table('tb_barang_pv as a')->join('tb_jurnal as b', 'a.id_barang', 'b.id_barang_pv')->where('a.id_jenis', 4)->get();
        $data_barang = DB::table('tb_barang_pv as a')->join('tb_satuan as b', 'a.id_satuan', 'b.id_satuan')->get();
        $h_pakan = DB::select("SELECT a.tgl,b.nm_barang, a.debit, a.qty FROM tb_jurnal as a
        LEFT JOIN tb_barang_pv as b ON a.id_barang_pv = b.id_barang
                    WHERE b.id_jenis = 1 AND a.debit != 0
                    ");

        $data = [
            'title' => 'Layer',
            'kandangData' => $kandang,
            'jenis' => $jenis,
            'tglhariIni' => $tgl,
            'tglKemarin' => $tglK,
            'pakan' => $pakan,
            'data_barang' => $data_barang,
            'obat' => $obat,
            'obat_air' => $obat_air,
            'obat_ayam' => $obat_ayam,
            'harga_pakan' => $h_pakan
        ];

        return view('layer.layer', $data);
    }

    public function getPopulasi(Request $r)
    {
        $id_kandang = $r->id_kandang;
        $tgl = $r->tgl;

        $tgl1 = date('Y-m-d', strtotime('-1 days', strtotime($tgl))); //kurang tanggal sebanyak 6 hari
        $populasi = DB::table('tb_populasi')->where([['id_kandang', $id_kandang], ['tgl', $tgl1]])->first();


        echo empty($populasi) ? 'tidak ada data' : $populasi->populasi;
    }

    public function getPakan(Request $r)
    {
        $id_kandang = $r->id_kandang;
        $tgl = $r->tgl;
        $ada = DB::table('tb_pakan')->where([['id_kandang', $id_kandang], ['tgl', $tgl]])->first();
        if (empty($ada)) {
            echo 'T';
        } else {
            echo 'Y';
        }
    }

    public function getPersen(Request $r)
    {
        $id_kandang = $r->id_kandang;
        $persen = $r->persen;
        $id_pakan = $r->id_pakan;

        $psn = DB::selectOne("SELECT a.persen , a.id_dt_pakan, a.id_kandang, a.tgl
        FROM tb_pakan AS a 
        LEFT JOIN ( 
        SELECT MAX(b.tgl) AS tgl_akhir , b.id_dt_pakan, b.id_kandang
        FROM tb_pakan AS b
        GROUP BY b.id_dt_pakan, b.id_kandang
        ) as gl ON gl.id_kandang = a.id_kandang 
        
        WHERE a.tgl = gl.tgl_akhir and a.id_kandang = '$id_kandang' and a.id_dt_pakan = '$id_pakan'
        GROUP BY a.id_kandang, a.id_dt_pakan");

        echo empty($psn->persen) ? '' : $psn->persen;
    }

    public function getSatuanPakan(Request $r)
    {
        $id_obat_pakan = $r->id_obat_pakan;
        $max = DB::selectOne("SELECT MAX(a.tgl) AS tgl
        FROM tb_obat_pakan AS a");

        $obat = DB::selectOne("SELECT max(a.tgl) AS tgl, a.id_obat, b.nm_barang , max(a.dosis) AS dosis, max(a.campuran) AS campuran 
        FROM tb_obat_pakan AS a 
        left join tb_barang_pv AS b ON b.id_barang = a.id_obat
        where a.id_obat = '$id_obat_pakan' and a.tgl = '$max->tgl'
        GROUP BY a.id_obat");

        $obatSatuan = DB::selectOne("SELECT *,b.nm_satuan as satuan, c.nm_satuan as satuan2 FROM `tb_barang_pv` as a
        LEFT JOIN tb_satuan as b on a.id_satuan = b.id_satuan
        LEFT JOIN tb_satuan as c on a.id_satuan_pakai = c.id_satuan
        WHERE a.id_barang = '$id_obat_pakan'");
        
        $data = [
            'dosis' => $obat->dosis ?? 0,
            'satuan' => $obatSatuan->satuan,
            'campuran' => $obat->campuran ?? 0,
            'satuan2' => $obatSatuan->satuan2
        ];
        echo json_encode($data);
    }

    public function getSatuanAir(Request $r)
    {
        $id_obat_pakan = $r->id_obat_pakan;
        $obat = DB::selectOne("SELECT *,b.nm_satuan as satuan, c.nm_satuan as satuan2 FROM `tb_barang_pv` as a
        LEFT JOIN tb_satuan as b on a.id_satuan = b.id_satuan
        LEFT JOIN tb_satuan as c on a.id_satuan_pakai = c.id_satuan
        WHERE a.id_barang = '$id_obat_pakan'");
    
        $data = [
            'satuan' => $obat->satuan,
            'satuan2' => $obat->satuan2
        ];
        echo json_encode($data);
    }

    public function getSatuanObatAyam(Request $r)
    {
        $id_obat = $r->id_obat;
        $obat = DB::table('tb_barang_pv as a')->join('tb_satuan as b', 'a.id_satuan', 'b.id_satuan')->where('a.id_barang', $id_obat)->first();

        echo $obat->nm_satuan;
    }

    public function inputPerencanaan(Request $r)
    {
        $tgl = $r->tgl;
        $id_kandang = $r->id_kandang;
        $kgPakanBox = $r->kgPakanBox;

        $populasi = $r->populasi;
        $grPakanEkor = $r->grPakanEkor;
        $kgKarung = $r->kgKarung;
        $kgKarungSisa = $r->kgKarungSisa;
        $id_pakan = $r->id_pakan;
        $persenPakan = $r->persenPakan;
        $pakanGr = $r->pakanGr;
        $pakanGrTotal = $r->pakanGrTotal;

        $id_obatPakan = $r->id_obatPakan;
        $dosisPakan = $r->dosisPakan;
        $satuanObat = $r->satuanObat;
        $obatCampuran = $r->obatCampuran;
        $satuanObat2 = $r->satuanObat2;

        $id_obatAir = $r->id_obatAir;
        $dosisAir = $r->dosisAir;
        $satuanObatAir = $r->satuanObatAir;
        $obatCampuranAir = $r->obatCampuranAir;
        $satuanObatAir2 = $r->satuanObatAir2;
        $waktuObat = $r->waktuObat;
        $caraPemakaian = $r->caraPemakaian;
        $ket = $r->ket;

        $id_obatAyam = $r->id_obatAyam;
        $dosisObatAyam = $r->dosisObatAyam;
        $obatAyamSatuan = $r->obatAyamSatuan;

        // dd(!empty($kgPakanBox));
        
        // $kd_gabungan = "TLR" . date($tgl[0]) . Str::upper(Str::random(3));

        $nota = DB::selectOne("SELECT max(a.no_nota) as nota FROM tb_asset_pv as a");
        $kd_gabungan = empty($nota->nota) ? '1001' : $nota->nota+1;

        $ttl_gr = 0;
 
        if (!empty($id_pakan[0])) {
            for ($i = 0; $i < count($id_pakan); $i++) {
                $hargaSatuan = DB::selectOne("SELECT sum(a.qty) as qty, sum(a.debit) as debit 
                FROM tb_jurnal as a 
                where a.id_barang_pv = '1' AND a.debit != 0 
                GROUP BY a.id_barang_pv");
                // dd($hargaSatuan->debit / $hargaSatuan->qty);
                $ttl_gr += $pakanGr[$i] / 1000;
                $tl_gr = $pakanGr[$i] / 1000;

                $data = [
                    'tgl' => $tgl,
                    'id_kandang' => $id_kandang,
                    'id_dt_pakan' => $id_pakan[$i],
                    'persen' => $persenPakan[$i],
                    'gr_pakan' => $tl_gr,
                    'no_nota' => "PRC-$kd_gabungan",
                    'admin' => Auth::user()->name
                ];
                
                DB::table('tb_pakan')->insert($data);
                
                $kandang = DB::table('tb_kandang')->where('id_kandang', $id_kandang)->first();
                $data_stok_pakan = [
                    'tgl' => $tgl,
                    'id_barang' => $id_pakan[$i],
                    'kredit' => $tl_gr,
                    'admin' => Auth::user()->name,
                    'no_nota' => "PRC-$kd_gabungan",
                    'ket' => 'Kandang' . ' ' . $kandang->nm_kandang
                ];
                DB::table('tb_asset_pv')->insert($data_stok_pakan);
                
                $debit = $tl_gr * ($hargaSatuan->debit / $hargaSatuan->qty);

                $data_metode = [
                    'id_buku' => 3,
                    'id_akun' => '41',
                    'id_barang_pv' => $id_pakan[$i],
                    'no_nota' => 'PRC-' . $kd_gabungan,
                    'kredit' => $debit,
                    'tgl' => $tgl,
                    'ket' => 'Pengeluaran Pakan',
                    'admin' => Auth::user()->name,
                ];
                DB::table('tb_jurnal')->insert($data_metode);
        
                $data_debit = [
                    'id_buku' => 3,
                    'id_akun' => '42',
                    'no_nota' => 'PRC-' . $kd_gabungan,
                    'urutan' => $kd_gabungan,
                    'debit' => $debit,
                    'tgl' => $tgl,
                    'ket' => 'Pengeluaran pakan',
                    'admin' => Auth::user()->name,
                ];
                DB::table('tb_jurnal')->insert($data_debit);
            }
        }

        if(!empty($kgPakanBox)) {
            $dataKarung = [
                'tgl' => $tgl,
                'id_kandang' => $id_kandang,
                'karung' => $kgPakanBox,
                'gr' => $kgKarung,
                'gr2' => $kgKarungSisa,
                'no_nota' => "PRC-$kd_gabungan",
            ];
            DB::table('tb_karung')->insert($dataKarung);
        }
        
        // dosis obat pakan
        if(!empty($id_obatPakan[0])) {
            for ($i=0; $i < count($id_obatPakan); $i++) { 
                $total = $ttl_gr * $dosisPakan[$i];
                $data2 = [
                    'tgl' => $tgl,
                    'id_kandang' => $id_kandang,
                    'id_obat' => $id_obatPakan[$i],
                    'dosis' => $dosisPakan[$i],
                    'satuan' => $satuanObat[$i],
                    'campuran' => $obatCampuran[$i],
                    'satuan2' => $satuanObat2[$i],
                    'ttl_gr' => $total,
                    'no_nota' => "PRC-$kd_gabungan",
                ];
                
                DB::table('tb_obat_pakan')->insert($data2);

                $hargaSatuanObat = DB::selectOne("SELECT sum(a.qty) as qty, sum(a.debit) as debit 
                FROM tb_jurnal as a 
                where a.id_barang_pv = '$id_obatPakan[$i]' AND a.debit != 0 
                GROUP BY a.id_barang_pv");

                $h_satuan = round($hargaSatuanObat->debit / $hargaSatuanObat->qty,0);

                $data_metode1 = [
                    'id_buku' => 3,
                    'id_akun' => '39',
                    'id_barang_pv' => $id_obatPakan[$i],
                    'no_nota' => 'PRC-' . $kd_gabungan,
                    'kredit' => round($h_satuan * $total,0),
                    'tgl' => $tgl,
                    'ket' => 'Pengeluaran Obat Pakan',
                    'admin' => Auth::user()->name,
                ];
                DB::table('tb_jurnal')->insert($data_metode1);
        
                $data_debit1 = [
                    'id_buku' => 3,
                    'id_akun' => '40',
                    'no_nota' => 'PRC-' . $kd_gabungan,
                    'urutan' => $kd_gabungan,
                    'debit' => round($h_satuan * $total,0),
                    'tgl' => $tgl,
                    'ket' => 'Pengeluaran Obat Pakan',
                    'admin' => Auth::user()->name,
                ];
                DB::table('tb_jurnal')->insert($data_debit1);

                $data_stok_obatpakan = [
                    'tgl' => $tgl,
                    'id_barang' => $id_obatPakan[$i],
                    'kredit' => $total,
                    'admin' => Auth::user()->name,
                    'no_nota' => "PRC-$kd_gabungan",
                    'ket' => 'Kandang' . ' ' . $kandang->nm_kandang
                ];
                DB::table('tb_asset_pv')->insert($data_stok_obatpakan);
            }

        }

        // ----- dosis obat air
        if(!empty($id_obatAir[0])) {
            for ($i=0; $i < count($id_obatAir); $i++) { 
                $kandang = DB::table('tb_kandang')->where('id_kandang', $id_kandang)->first();
                    $data_stok_pakan = [
                        'id_obat' => $id_obatAir[$i],
                        'no_nota' => "PRC-$kd_gabungan",
                        'dosis' => $dosisAir[$i],
                        'satuan' => $satuanObatAir[$i],
                        'campuran' => $obatCampuranAir[$i],
                        'satuan2' => $satuanObatAir2[$i],
                        'waktu' => $waktuObat[$i],
                        'ket' => $ket[$i],
                        'id_kandang' => $id_kandang,
                        'tgl' => $tgl,
                        'cara' => $caraPemakaian[$i]
                    ];
                    
                    DB::table('tb_obat_air')->insert($data_stok_pakan);
                    
                    $dataObat2 = [
                        'tgl' => $tgl,
                        'id_barang' => $id_obatAir[$i],
                        'kredit' => $dosisAir[$i],
                        'admin' => Auth::user()->name,
                        'no_nota' => "PRC-$kd_gabungan",
                        'ket' => 'Kandang' . ' ' . $kandang->nm_kandang
                    ];
                    DB::table('tb_asset_pv')->insert($dataObat2);
                    
                    $hargaSatuanObatAir = DB::selectOne("SELECT sum(a.qty) as qty, sum(a.debit) as debit 
                    FROM tb_jurnal as a 
                    where a.id_barang_pv = '$id_obatAir[$i]' AND a.debit != 0 
                    GROUP BY a.id_barang_pv");

                    $h_satuan_air = round($hargaSatuanObatAir->debit / $hargaSatuanObatAir->qty,0);
                    $data_metode3 = [
                        'id_buku' => 3,
                        'id_akun' => '39',
                        'id_barang_pv' => $id_obatAir[$i],
                        'no_nota' => 'PRC-' . $kd_gabungan,
                        'kredit' => $h_satuan_air * $dosisAir[$i],
                        'tgl' => $tgl,
                        'ket' => 'Pengeluaran Obat Air',
                        'admin' => Auth::user()->name,
                    ];
                    DB::table('tb_jurnal')->insert($data_metode3);
            
                    $data_debit3 = [
                        'id_buku' => 3,
                        'id_akun' => '40',
                        'no_nota' => 'PRC-' . $kd_gabungan,
                        'urutan' => $kd_gabungan,
                        'debit' => $h_satuan_air * $dosisAir[$i],
                        'tgl' => $tgl,
                        'ket' => 'Pengeluaran Obat Pakan',
                        'admin' => Auth::user()->name,
                    ];
                    DB::table('tb_jurnal')->insert($data_debit3);
            }
        }

        // ----- dosis obat ayam
        $dosis_a = $dosisObatAyam * $populasi;
        if (!empty($id_obatAyam)) {
            $dataAyam = [
                'id_obat' => $id_obatAyam,
                'dosis' => $dosis_a,
                'satuan' => $obatAyamSatuan,
                'tgl' => $tgl,
                'dosis_awal' => $dosisObatAyam,
                'id_kandang' => $id_kandang,
                'no_nota' => "PRC-$kd_gabungan",
            ];
            DB::table('tb_obat_ayam')->insert($dataAyam);

            $data_stok_obatayam = [
                'tgl' => $tgl,
                'id_barang' => $id_obatAyam,
                'kredit' => $dosis_a,
                'admin' => Auth::user()->name,
                'no_nota' => "PRC-$kd_gabungan",
                'ket' => 'Kandang' . ' ' . $kandang->nm_kandang
            ];
            DB::table('tb_asset_pv')->insert($data_stok_obatayam);
        }

        return redirect()->route('layer')->with('sukses', 'Berhasil tambah perencanaan');
    }

    public function viewHistoryPerencanaan(Request $r)
    {
        $id_kandang = $r->id_kandang;
        $tgl = $r->tgl;
        $tgl1 = date('Y-m-d', strtotime('-1 days', strtotime($tgl)));
        $populasi = DB::table('tb_populasi')->where([['id_kandang', $id_kandang],['tgl', $tgl1]])->first();
        $kandang = DB::table('tb_kandang')->where('id_kandang', $id_kandang)->first();
        $pakan = DB::selectOne("SELECT *,sum(gr_pakan) as total FROM tb_pakan as a 
                    WHERE a.tgl = '$tgl' AND a.id_kandang = '$id_kandang' 
                    GROUP BY a.id_kandang");
        $umur = DB::selectOne("SELECT TIMESTAMPDIFF(WEEK, a.tgl_masuk, '$tgl') as mgg FROM tb_kandang as a 
        WHERE a.id_kandang = '$id_kandang'");

        $pakan1 = DB::table('tb_karung')->where([['id_kandang', $id_kandang],['tgl', $tgl]])->first();
     
        $pakan2 = DB::select("SELECT  a.tgl, b.nm_barang as nm_pakan, a.persen, a.gr_pakan
        FROM tb_pakan as a 
        left join tb_barang_pv as b on a.id_dt_pakan = b.id_barang 
        where a.id_kandang = '$id_kandang' AND  tgl = '$tgl'");

        $obat1 = DB::select("SELECT a.tgl, b.nm_barang as nm_obat , a.id_kandang, a.dosis, a.satuan, a.campuran, a.satuan2 
        FROM tb_obat_pakan AS a
        LEFT JOIN tb_barang_pv AS b ON b.id_barang = a.id_obat
        LEFT JOIN tb_kandang AS c ON c.id_kandang = a.id_kandang
        where a.tgl = '$tgl' and a.id_kandang = '$id_kandang'");

        $obat_air = DB::select("SELECT a.id_kandang, a.tgl, b.nm_barang as nm_obat, a.dosis, a.satuan, a.campuran, a.satuan2, a.waktu, a.ket, a.cara
        FROM tb_obat_air AS a
        LEFT JOIN tb_barang_pv AS b ON b.id_barang = a.id_obat where a.tgl = '$tgl' and a.id_kandang = '$id_kandang'");

        $obat_ayam = DB::select("SELECT a.* , b.nm_barang as nm_obat FROM tb_obat_ayam AS a
        LEFT JOIN tb_barang_pv AS b ON b.id_barang = a.id_obat where a.tgl = '$tgl' and a.id_kandang = '$id_kandang'");

        $data = [
            'tgl_per' => $tgl,
            'id_kandang' => $id_kandang,
            'kandang' => $kandang,
            'pakan' => $pakan,
            'populasi' => $populasi,
            'umur' => $umur,
            'pakan1' => $pakan1,
            'pakan2' => $pakan2,
            'obat1' => $obat1,
            'obat_air' => $obat_air,
            'obat_ayam' => $obat_ayam,
        ];
        return view("layer.history.hasilPerencanaan", $data);
    }

    public function viewHistoryStok(Request $r)
    {
        $tgl = $r->tgl;
        $obat = DB::select("SELECT a.qty,c.nm_satuan,a.debit, b.id_barang, b.nm_barang FROM `tb_jurnal` as a
        LEFT JOIN tb_barang_pv as b ON a.id_barang_pv = b.id_barang
        LEFT JOIN tb_satuan as c ON b.id_satuan = c.id_satuan
        WHERE b.id_jenis = 2 AND a.qty != 0;");
        $data = [
            // 'kardus' => $kardus,
            'obat' => $obat,
            'tgl' => $tgl,
        ];
        return view("layer.history.hasilStok", $data);
    }

    public function viewHistoryPullet(Request $r)
    {
        $tgl1 = $r->tgl1;
        $tgl2 = $r->tgl2;
        $id_kandang = $r->id_kandang;
        $kandang = DB::table('tb_kandang')->where('id_kandang', $id_kandang)->first();
        $pakan = DB::select("SELECT b.admin,d.nm_jenis,c.nm_satuan,a.id_dt_pakan as id_pakan, a.id_kandang, a.tgl, b.nm_barang, sum(a.gr_pakan) as qty FROM tb_pakan as a
        LEFT JOIN tb_barang_pv as b ON a.id_dt_pakan = b.id_barang
        LEFT JOIN tb_satuan as c ON b.id_satuan = c.id_satuan
        LEFT JOIN tb_jenis as d ON b.id_jenis = d.id_jenis
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2' AND a.id_kandang = '$id_kandang'
        GROUP BY a.id_dt_pakan
        ORDER BY a.tgl DESC;");

        $data = [
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kandang' =>  $kandang,
            'id_kandang' =>  $id_kandang,
            'pakan' =>  $pakan,
        ];

        return view("layer.history.hasilPullet",$data);
    }

    public function viewHistoryEditPerencanaan(Request $r)
    {
        $tgl = $r->tgl;
        $tgl1 = date('Y-m-d', strtotime('-1 days', strtotime($tgl)));
        $id_kandang = $r->id_kandang;
        $pakan_id = DB::select("SELECT  a.id_pakan,a.tgl,b.id_barang, b.nm_barang as nm_pakan, a.persen, a.gr_pakan
                    FROM tb_pakan as a 
                    left join tb_barang_pv as b on a.id_dt_pakan = b.id_barang 
                    where a.id_kandang = '$id_kandang' AND  tgl = '$tgl'");
        
        $pakan = DB::table('tb_barang_pv')->where('id_jenis', 1)->get();
        $karung = DB::table('tb_karung')->where([['id_kandang', $id_kandang],['tgl', $tgl]])->first();
        $kandang = DB::table('tb_kandang')->get();
        $populasi = DB::table('tb_populasi')->where([['id_kandang', $id_kandang],['tgl', $tgl1]])->first();
        $gr_pakan = DB::selectOne("SELECT sum(a.gr_pakan) as ttl FROM tb_pakan as a where a.id_kandang = '$id_kandang' and a.tgl = '$tgl' group by a.id_kandang");
        $obat_pakan = DB::table('tb_obat_pakan')->where([['id_kandang', $id_kandang],['tgl', $tgl]])->get();
        $obat_air = DB::table('tb_obat_air')->where([['id_kandang', $id_kandang],['tgl', $tgl]])->get();;
        $obat = DB::table('tb_barang_pv')->where('id_jenis', 2)->get();
        $obat_air2 = DB::table('tb_barang_pv')->where('id_jenis', 3)->get();
        $obat_ayam = DB::table('tb_barang_pv')->where('id_jenis', 4)->get();
        $obat_aym = DB::table('tb_obat_ayam')->where([['id_kandang', $id_kandang],['tgl', $tgl]])->get();

        $data = [
            'tgl' => $tgl,
            'id_kandang' => $id_kandang,
            'pakan_id' => $pakan_id,
            'pakan' => $pakan,
            'karung' => $karung,
            'kandang' => $kandang,
            'populasi' => $populasi,
            'gr_pakan' => $gr_pakan,
            'obat_pakan' => $obat_pakan,
            'obat_air' => $obat_air,
            'obat' => $obat,
            'obat_air2' => $obat_air2,
            'obat_ayam' => $obat_ayam,
            'obat_aym' => $obat_aym,
        ];
        return view('layer.history.modalEditPerencanaan', $data);
    }

    public function editPerencanaan(Request $r)
    {
        $tgl = $r->tgl;
        $id_kandang = $r->id_kandang;
        $kgPakanBox = $r->kgPakanBox;
        $populasi = $r->populasi;
        
        $grPakanEkor = $r->grPakanEkor;
        $kgKarung = $r->kgKarung;
        $kgKarungSisa = $r->kgKarungSisa;
        $id_pakan = $r->id_pakan;
        $persenPakan = $r->persenPakan;
        $pakanGr = $r->pakanGr;
        $pakanGrTotal = $r->pakanGrTotal;
        
        $id_obatPakan = $r->id_obatPakan;
        $dosisPakan = $r->dosisPakan;
        $satuanObat = $r->satuanObat;
        $obatCampuran = $r->obatCampuran;
        $satuanObat2 = $r->satuanObat2;
        
        $id_obatAir = $r->id_obatAir;
        $dosisAir = $r->dosisAir;
        $satuanObatAir = $r->satuanObatAir;
        $obatCampuranAir = $r->obatCampuranAir;
        $satuanObatAir2 = $r->satuanObatAir2;
        $waktuObat = $r->waktuObat;
        $caraPemakaian = $r->caraPemakaian;
        $ket = $r->ket;
        
        $id_obatAyam = $r->id_obatAyam;
        $dosisObatAyam = $r->dosisObatAyam;
        $obatAyamSatuan = $r->obatAyamSatuan;
        
        // id edit hidden
        $id_krng = $r->id_krng;
        $id_dt_pakan = $r->id_dt_pakan;
        $id_obat_pkn = $r->id_obat_pkn;
        $id_obat_air2 = $r->id_obat_air2;
        $id_obat_ayam = $r->id_obat_ayam;
        $no_nota = $r->id_no_nota;
        $urutan = Str::after($no_nota, '-');

        DB::table('tb_pakan')->where('no_nota',$no_nota)->delete();
        DB::table('tb_karung')->where('no_nota',$no_nota)->delete();
        DB::table('tb_obat_pakan')->where('no_nota',$no_nota)->delete();
        DB::table('tb_obat_air')->where('no_nota',$no_nota)->delete();
        DB::table('tb_obat_ayam')->where('no_nota',$no_nota)->delete();
        DB::table('tb_jurnal')->where('no_nota',$no_nota)->delete();
        DB::table('tb_asset_pv')->where('no_nota',$no_nota)->delete();

        $ttl_gr = 0;
 
        if (!empty($id_pakan)) {
            for ($i = 0; $i < count($id_pakan); $i++) {
                $hargaSatuan = DB::selectOne("SELECT sum(a.qty) as qty, sum(a.debit) as debit 
                FROM tb_jurnal as a 
                where a.id_barang_pv = '$id_pakan[$i]' AND a.debit != 0 
                GROUP BY a.id_barang_pv");

                $ttl_gr += $pakanGr[$i] / 1000;
                $tl_gr = $pakanGr[$i] / 1000;

                $data = [
                    'tgl' => $tgl,
                    'id_kandang' => $id_kandang,
                    'id_dt_pakan' => $id_pakan[$i],
                    'persen' => $persenPakan[$i],
                    'gr_pakan' => $tl_gr,
                    'no_nota' => $no_nota,
                    'admin' => Auth::user()->name
                ];
                
                DB::table('tb_pakan')->insert($data);
                
                $kandang = DB::table('tb_kandang')->where('id_kandang', $id_kandang)->first();
                $data_stok_pakan = [
                    'tgl' => $tgl,
                    'id_barang' => $id_pakan[$i],
                    'kredit' => $tl_gr,
                    'admin' => Auth::user()->name,
                    'no_nota' => $no_nota,
                    'ket' => 'Kandang' . ' ' . $kandang->nm_kandang
                ];
                DB::table('tb_asset_pv')->insert($data_stok_pakan);
                
                $debit = $tl_gr * ($hargaSatuan->debit / $hargaSatuan->qty);

                $data_metode = [
                    'id_buku' => 3,
                    'id_akun' => '41',
                    'id_barang_pv' => $id_pakan[$i],
                    'no_nota' => $no_nota,
                    'kredit' => $debit,
                    'tgl' => $tgl,
                    'ket' => 'Pengeluaran Pakan',
                    'admin' => Auth::user()->name,
                ];
                DB::table('tb_jurnal')->insert($data_metode);
        
                $data_debit = [
                    'id_buku' => 3,
                    'id_akun' => '42',
                    'id_barang_pv' => $id_pakan[$i],
                    'no_nota' => $no_nota,
                    'urutan' => $urutan,
                    'debit' => $debit,
                    'tgl' => $tgl,
                    'ket' => 'Pengeluaran pakan',
                    'admin' => Auth::user()->name,
                ];
                DB::table('tb_jurnal')->insert($data_debit);
            }
        }

        if(!empty($kgPakanBox)) {
            $dataKarung = [
                'tgl' => $tgl,
                'id_kandang' => $id_kandang,
                'karung' => $kgPakanBox,
                'gr' => $kgKarung,
                'gr2' => $kgKarungSisa,
                'no_nota' => $no_nota,
            ];
            DB::table('tb_karung')->insert($dataKarung);
        }
        
        // dosis obat pakan
        if(!empty($id_obatPakan)) {
            for ($i=0; $i < count($id_obatPakan); $i++) { 
                $total = $ttl_gr * $dosisPakan[$i];
                $data2 = [
                    'tgl' => $tgl,
                    'id_kandang' => $id_kandang,
                    'id_obat' => $id_obatPakan[$i],
                    'dosis' => $dosisPakan[$i],
                    'satuan' => $satuanObat[$i],
                    'campuran' => $obatCampuran[$i],
                    'satuan2' => $satuanObat2[$i],
                    'ttl_gr' => $total,
                    'no_nota' => $no_nota,
                ];
                
                DB::table('tb_obat_pakan')->insert($data2);

                $hargaSatuanObat = DB::selectOne("SELECT sum(a.qty) as qty, sum(a.debit) as debit 
                FROM tb_jurnal as a 
                where a.id_barang_pv = '$id_obatPakan[$i]' AND a.debit != 0 
                GROUP BY a.id_barang_pv");

                $h_satuan = round($hargaSatuanObat->debit / $hargaSatuanObat->qty,0);

                $data_metode1 = [
                    'id_buku' => 3,
                    'id_akun' => '39',
                    'id_barang_pv' => $id_obatPakan[$i],
                    'no_nota' => $no_nota,
                    'kredit' => round($h_satuan * $total,0),
                    'tgl' => $tgl,
                    'ket' => 'Pengeluaran Obat Pakan',
                    'admin' => Auth::user()->name,
                ];
                DB::table('tb_jurnal')->insert($data_metode1);
        
                $data_debit1 = [
                    'id_buku' => 3,
                    'id_akun' => '40',
                    'id_barang_pv' => $id_obatPakan[$i],
                    'no_nota' => $no_nota,
                    'urutan' => $urutan,
                    'debit' => round($h_satuan * $total,0),
                    'tgl' => $tgl,
                    'ket' => 'Pengeluaran Obat Pakan',
                    'admin' => Auth::user()->name,
                ];
                DB::table('tb_jurnal')->insert($data_debit1);

                $data_stok_obatpakan = [
                    'tgl' => $tgl,
                    'id_barang' => $id_obatPakan[$i],
                    'kredit' => $total,
                    'admin' => Auth::user()->name,
                    'no_nota' => $no_nota,
                    'ket' => 'Kandang' . ' ' . $kandang->nm_kandang
                ];
                DB::table('tb_asset_pv')->insert($data_stok_obatpakan);
            }

        }

        // ----- dosis obat air
        if(!empty($id_obatAir)) {
            for ($i=0; $i < count($id_obatAir); $i++) { 
                $kandang = DB::table('tb_kandang')->where('id_kandang', $id_kandang)->first();
                    $data_stok_pakan = [
                        'id_obat' => $id_obatAir[$i],
                        'no_nota' => $no_nota,
                        'dosis' => $dosisAir[$i],
                        'satuan' => $satuanObatAir[$i],
                        'campuran' => $obatCampuranAir[$i],
                        'satuan2' => $satuanObatAir2[$i],
                        'waktu' => $waktuObat[$i],
                        'ket' => $ket[$i],
                        'id_kandang' => $id_kandang,
                        'tgl' => $tgl,
                        'cara' => $caraPemakaian[$i]
                    ];
                    
                    DB::table('tb_obat_air')->insert($data_stok_pakan);
                    
                    $dataObat2 = [
                        'tgl' => $tgl,
                        'id_barang' => $id_obatAir[$i],
                        'kredit' => $dosisAir[$i],
                        'admin' => Auth::user()->name,
                        'no_nota' => $no_nota,
                        'ket' => 'Kandang' . ' ' . $kandang->nm_kandang
                    ];
                    DB::table('tb_asset_pv')->insert($dataObat2);
                    
                    $hargaSatuanObatAir = DB::selectOne("SELECT sum(a.qty) as qty, sum(a.debit) as debit 
                    FROM tb_jurnal as a 
                    where a.id_barang_pv = '$id_obatAir[$i]' AND a.debit != 0 
                    GROUP BY a.id_barang_pv");

                    $h_satuan_air = round($hargaSatuanObatAir->debit / $hargaSatuanObatAir->qty,0);
                    $data_metode3 = [
                        'id_buku' => 3,
                        'id_akun' => '39',
                        'id_barang_pv' => $id_obatAir[$i],
                        'no_nota' => $no_nota,
                        'kredit' => $h_satuan_air * $dosisAir[$i],
                        'tgl' => $tgl,
                        'ket' => 'Pengeluaran Obat Air',
                        'admin' => Auth::user()->name,
                    ];
                    DB::table('tb_jurnal')->insert($data_metode3);
            
                    $data_debit3 = [
                        'id_buku' => 3,
                        'id_akun' => '40',
                        'id_barang_pv' => $id_obatAir[$i],
                        'no_nota' => $no_nota,
                        'urutan' => $urutan,
                        'debit' => $h_satuan_air * $dosisAir[$i],
                        'tgl' => $tgl,
                        'ket' => 'Pengeluaran Obat Pakan',
                        'admin' => Auth::user()->name,
                    ];
                    DB::table('tb_jurnal')->insert($data_debit3);
            }
        }

        // ----- dosis obat ayam
        $dosis_a = $dosisObatAyam * $populasi;
        if (!empty($id_obatAyam)) {
            $dataAyam = [
                'id_obat' => $id_obatAyam,
                'dosis' => $dosis_a,
                'satuan' => $obatAyamSatuan,
                'tgl' => $tgl,
                'dosis_awal' => $dosisObatAyam,
                'id_kandang' => $id_kandang,
                'no_nota' => $no_nota,
            ];
            DB::table('tb_obat_ayam')->insert($dataAyam);

            $data_stok_obatayam = [
                'tgl' => $tgl,
                'id_barang' => $id_obatAyam,
                'kredit' => $dosis_a,
                'admin' => Auth::user()->name,
                'no_nota' => $no_nota,
                'ket' => 'Kandang' . ' ' . $kandang->nm_kandang
            ];
            DB::table('tb_asset_pv')->insert($data_stok_obatayam);
        }

        return redirect()->route('layer')->with('sukses', 'Berhasil tambah perencanaan');

    }

    public function hasilLayer(Request $r)
    {
        $tujuh_hari   = mktime(0, 0, 0, date("n"), date("j") - 1, date("Y"));
        $tglK = date('Y-m-d', $tujuh_hari);
        $tgl = $r->tgl;
        $kandang = DB::select("SELECT *,TIMESTAMPDIFF(WEEK, tgl_masuk , '$tgl') AS mgg FROM tb_kandang WHERE selesai = 'T'");
        $jenis = DB::table('tb_jenis_telur')->get();
        $data = [
            'tgl' => $r->tgl,
            'kandangData' => $kandang,
            'jenis' => $jenis,
            'tglhariIni' => $tgl,
            'tglKemarin' => $tglK,
        ];
        return view('layer.history.hasilLayer', $data);
    }

    public function editLayer(Request $r)
    {

        $kandang = DB::table('tb_telur as a')->join('tb_kandang as b', 'a.id_kandang', 'b.id_kandang')->where('a.nota', $r->nota)->first();
        $jenis = DB::table('tb_jenis_telur')->get();

        $data = [
            'kandangData' => $kandang,
            'jenis' => $jenis,
            'tgl' => $r->tgl
        ];
        return view('layer.history.modalEditLayer', $data);
    }

    public function editTelur(Request $r)
    {
        for ($i = 0; $i < count($r->pcs); $i++) {

            $data = [
                'admin' => Auth::user()->name,
                'pcs' => $r->pcs[$i],
                'kg' => $r->kg[$i],
            ];
            DB::table('tb_telur')->where('id_telur', $r->id_telur[$i])->update($data);
        }
        return redirect()->route('layer')->with('sukses', "Berhasil ubah data telur");
    }

    public function kandang()
    {
        $data = [
            'title' => 'Kandang',
            'kandang' => DB::table('tb_kandang as a')->join('tb_strain as b', 'a.id_strain', 'b.id_strain')->get(),
            'strain' => DB::table('tb_strain')->get()
        ];
        return view('kandang.kandang', $data);
    }

    public function addKandang(Request $r)
    {
        $data = [
            'nm_kandang' => $r->nm_kandang,
            'ayam_awal' => $r->ayam_awal,
            'id_strain' => $r->id_strain,
            'tgl_masuk' => $r->tgl_masuk,
            'selesai' => 'T',
        ];
        DB::table('tb_kandang')->insert($data);
        return redirect()->route('kandang')->with('sukses', "Data berhasil ditambahkan");
    }

    public function editModalkandang(Request $r)
    {

        return view('kandang.modal', [
            'kandang' => DB::table('tb_kandang')->where('id_kandang', $r->id_kandang)->first(),
            'strain' => DB::table('tb_strain')->get()
        ]);
    }

    public function editKandang(Request $r)
    {
        $data = [
            'nm_kandang' => $r->nm_kandang,
            'ayam_awal' => $r->ayam_awal,
            'id_strain' => $r->id_strain,
            'tgl_masuk' => $r->tgl_masuk,
        ];


        DB::table('tb_kandang')->where('id_kandang', $r->id_kandang)->update($data);

        return redirect()->route('kandang')->with('sukses', 'Data berhasil diubah');
    }

    public function status($tipe, $id_kandang)
    {
        DB::table('tb_kandang')->where('id_kandang', $id_kandang)->update([
            'selesai' => $tipe == 'selesai' ? 'Y' : 'T'
        ]);
        $kandang = DB::table('tb_kandang')->where('id_kandang', $id_kandang)->first();
        return redirect()->route('kandang')->with('sukses', "Data Kandang : $kandang->nm_kandang diubah");
    }

    public function obat()
    {
        $data = [
            'title' => 'Obat',
            'obat' => DB::select("SELECT *,c.nm_satuan as satuan, d.nm_satuan as satuan2 FROM `tb_barang_pv` as a
                          LEFT join tb_jenis as b on a.id_jenis = b.id_jenis
                          LEFT JOIN tb_satuan as c ON a.id_satuan= c.id_satuan
                          LEFT JOIN tb_satuan as d ON a.id_satuan_pakai = d.id_satuan
                          WHERE a.id_jenis != 1
                          "),
            'jenis' => DB::table('tb_jenis')->where('id_jenis', '!=', 1)->get(),
            'satuan' => DB::table('tb_satuan')->get(),
        ];

        return view('obat.obat', $data);
    }

    public function addObat(Request $r)
    {
        $data = [
            'nm_barang' => $r->nm_obat,
            'id_jenis' => $r->id_jenis,
            'id_satuan' => $r->satuan,
            'id_satuan_pakai' => $r->satuan2,
            'id_akun' => 2,
            'admin' => Auth::user()->name,
            'dosis' => $r->dosis,
            'campuran' => $r->campuran,
            'kegunaan' => $r->kegunaan
        ];

        DB::table('tb_barang_pv')->insert($data);
        return redirect()->route('obat')->with('sukses', "Data berhasil ditambahkan");
    }

    public function editModalObat(Request $r)
    {
        return view('obat.modal', [
            'obat' => DB::table('tb_barang_pv')->where('id_barang', $r->id_obat)->first(),
            'jenis' => DB::table('tb_jenis')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
        ]);
    }

    public function editObat(Request $r)
    {
        $data = [
            'nm_barang' => $r->nm_obat,
            'id_jenis' => $r->id_jenis,
            'id_satuan' => $r->satuan,
            'id_satuan_pakai' => $r->satuan2,
            'admin' => Auth::user()->name,
            'dosis' => $r->dosis,
            'campuran' => $r->campuran,
            'kegunaan' => $r->kegunaan
        ];

        DB::table('tb_barang_pv')->where('id_barang', $r->id_obat)->update($data);

        return redirect()->route('obat')->with('sukses', 'Data berhasil diubah');
    }

    public function deleteObat($id)
    {
        $cekStok = DB::table('tb_asset_pv as a')->join('tb_barang_pv as b', 'a.id_barang', 'b.id_barang')->where('a.id_barang',$id)->first();
        $tipe = !empty($cekStok) ? 'error' : 'sukses';
        $pesan = !empty($cekStok) ? "Obat $cekStok->nm_barang tersedia di stok" : "Data berhasil dihapus";
        if($tipe == 'error') {
            return redirect()->route('obat')->with($tipe, $pesan);
        } else {
            DB::table('tb_barang_pv')->where('id_barang', $id)->delete();
            return redirect()->route('obat')->with($tipe, $pesan);
        }
        
    }

    public function exportObat()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet
            ->setCellValue('A1', 'ID Obat')
            ->setCellValue('B1', 'Nama Obat')
            ->setCellValue('C1', 'Jenis')
            ->setCellValue('D1', 'Dosis')
            ->setCellValue('E1', 'Satuan')
            ->setCellValue('F1', 'Campuran')
            ->setCellValue('G1', 'Satuan')
            ->setCellValue('H1', 'Kegunaan');

        $obat = DB::select("SELECT *,c.nm_satuan as satuan, d.nm_satuan as satuan2 FROM `tb_obat` as a
        LEFT join tb_jenis as b on a.id_jenis = b.id_jenis
        LEFT JOIN tb_satuan as c ON a.satuan= c.id_satuan
        LEFT JOIN tb_satuan as d ON a.satuan2 = d.id_satuan");

        $kolom = 2;
        foreach ($obat as $n) {
            $sheet->setCellValue('A' . $kolom, $n->id_obat)
                ->setCellValue('B' . $kolom, $n->nm_obat)
                ->setCellValue('C' . $kolom, $n->nm_jenis)
                ->setCellValue('D' . $kolom, $n->dosis)
                ->setCellValue('E' . $kolom, $n->satuan)
                ->setCellValue('F' . $kolom, $n->campuran)
                ->setCellValue('G' . $kolom, $n->satuan2)
                ->setCellValue('H' . $kolom, $n->kegunaan);
            $kolom++;
        }

        $writer = new Xlsx($spreadsheet);
        $style = [
            'borders' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];
        // tambah style
        $batas = count($obat) + 1;
        $sheet->getStyle('A1:H' . $batas)->applyFromArray($style);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data Obat.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function pakan()
    {
        $data = [
            'title' => 'Pakan',
            'obat' => DB::select("SELECT *,c.nm_satuan as satuan, d.nm_satuan as satuan2 FROM `tb_barang_pv` as a
                          LEFT join tb_jenis as b on a.id_jenis = b.id_jenis
                          LEFT JOIN tb_satuan as c ON a.id_satuan= c.id_satuan
                          LEFT JOIN tb_satuan as d ON a.id_satuan_pakai = d.id_satuan
                          WHERE a.id_jenis = 1
                          "),
            'jenis' => DB::table('tb_jenis')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
        ];

        return view('pakan.pakan', $data);
    }

    public function addPakan(Request $r)
    {
        $data = [
            'nm_barang' => $r->nm_obat,
            'id_jenis' => 1,
            'id_akun' => 2,
            'admin' => Auth::user()->name,
            'kegunaan' => $r->kegunaan
        ];

        DB::table('tb_barang_pv')->insert($data);
        return redirect()->route('pakan')->with('sukses', "Data berhasil ditambahkan");
    }

    public function editModalPakan(Request $r)
    {
        return view('pakan.modal', [
            'obat' => DB::table('tb_barang_pv')->where('id_barang', $r->id_obat)->first(),
            'jenis' => DB::table('tb_jenis')->get(),
            'satuan' => DB::table('tb_satuan')->get(),
        ]);
    }

    public function editPakan(Request $r)
    {
        $data = [
            'nm_barang' => $r->nm_obat,
            'id_akun' => 2,
            'admin' => Auth::user()->name,
            'kegunaan' => $r->kegunaan
        ];

        DB::table('tb_barang_pv')->where('id_barang', $r->id_obat)->update($data);

        return redirect()->route('pakan')->with('sukses', 'Data berhasil diubah');
    }

    public function deletePakan($id)
    {
        $cekStok = DB::table('tb_asset_pv as a')->join('tb_barang_pv as b', 'a.id_barang', 'b.id_barang')->where('a.id_barang',$id)->first();
        $tipe = !empty($cekStok) ? 'error' : 'sukses';
        $pesan = !empty($cekStok) ? "Obat $cekStok->nm_barang tersedia di stok" : "Data berhasil dihapus";
        if($tipe == 'error') {
            return redirect()->route('pakan')->with($tipe, $pesan);
        } else {
            DB::table('tb_barang_pv')->where('id_barang', $id)->delete();
            return redirect()->route('pakan')->with($tipe, $pesan);
        }
    }

    public function addVaksin(Request $r)
    {
        $data = [
            'vaksin' => $r->nm_vaksin,
            'tgl' => $r->tgl,
            'dosis' => $r->dosis,
            'cost' => $r->cost,
            'id_kandang' => $r->id_kandang,
            'admin' => Auth::user()->name,
        ];
        DB::table('tb_vaksin')->insert($data);
        return redirect()->route('layer')->with('sukses', "Data berhasil ditambahkan");
    }

    public function addPupuk(Request $r)
    {
        for ($i = 0; $i < count($r->id_kandang); $i++) {
            $data = [
                'tgl' => $r->tgl,
                'jumlah' => $r->jumlah[$i],
                'id_kandang' => $r->id_kandang[$i],
                'admin' => Auth::user()->name
            ];
            DB::table('tb_pupuk')->insert($data);
        }
        return redirect()->route('layer')->with('sukses', "Data Pupuk berhasil ditambahkan");
    }

    public function addTelur(Request $r)
    {
        // $id_kandang = [];
        for ($j = 0; $j < count($r->id_kandang); $j++) {

            $nota = DB::selectOne("SELECT max(a.nota) as nota FROM tb_telur as a");
            $no_nota = empty($nota->nota) ? '1001' : $nota->nota+1;

            for ($i = 0; $i < count($r->pcs); $i++) {

                $data = [
                    'tgl' => $r->tgl,
                    'id_kandang' => $r->id_kandang[$j],
                    'admin' => Auth::user()->name,
                    'nota' => $no_nota,
                    'pcs' => $r->pcs[$i],
                    'kg' => $r->kg[$i],
                    'id_jenis' => $r->id_jenis[$i],
                    'check' => 'T'
                ];
                DB::table('tb_telur')->insert($data);
            }
        }


        return redirect()->route('layer')->with('sukses', "Data Telur berhasil ditambahkan");
    }

    public function addPopulasi(Request $r)
    {
        for ($i = 0; $i < count($r->id_kandang); $i++) {
            $id_kandang = $r->id_kandang[$i];
            $cek = DB::table('tb_populasi')->where([['id_kandang', $id_kandang], ['tgl', $r->tgl]])->first();
            if (empty($cek)) {
                $ttl = $r->mati[$i] + $r->jual[$i];
                $kdg = DB::table('tb_kandang')->where('id_kandang', $id_kandang)->first();
                $populasi = Db::selectOne("SELECT dt.id_kandang, dt.death , dt.culling, sum(dt.populasi) as populasi FROM tb_populasi as dt
                                LEFT JOIN (SELECT MAX(b.tgl) AS tgl_max, b.id_kandang FROM tb_populasi AS b WHERE b.id_kandang = '$id_kandang' GROUP BY b.id_kandang) AS mx ON mx.id_kandang = dt.id_kandang
                                WHERE dt.tgl = mx.tgl_max");
                $popul = $populasi->populasi == null ? $kdg->ayam_awal : $populasi->populasi;
                // dd($popul);
                $data = [
                    'populasi' => $popul - $ttl,
                    'id_kandang' => $id_kandang,
                    'admin' => Auth::user()->name,
                    'death' => $r->mati[$i],
                    'culling' => $r->jual[$i],
                    'tgl' => $r->tgl,
                    'check' => 'T'
                ];

                DB::table('tb_populasi')->insert($data);
            }
        }
        return redirect()->route('layer')->with('sukses', "Data Populasi berhasil ditambahkan");
    }

}
