<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\KirimAyamController;
use App\Http\Controllers\LayerController;
use App\Http\Controllers\PenjualanTelurController;
use App\Http\Controllers\PerformaController;
use App\Http\Controllers\RakTelurController;
use App\Http\Controllers\SolarController;
use App\Http\Controllers\UserController;
use App\Mail\EmailTelur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    
    // layer
    Route::get('/layer', [LayerController::class, 'index'])->name('layer');
    Route::post('/addVaksin', [LayerController::class, 'addVaksin'])->name('addVaksin');
    Route::post('/addPupuk', [LayerController::class, 'addPupuk'])->name('addPupuk');
    Route::post('/addPopulasi', [LayerController::class, 'addPopulasi'])->name('addPopulasi');
    Route::post('/addTelur', [LayerController::class, 'addTelur'])->name('addTelur');
    Route::get('/hasilLayer', [LayerController::class, 'hasilLayer'])->name('hasilLayer');
    Route::get('/editLayer', [LayerController::class, 'editLayer'])->name('editLayer');
    Route::get('/getPopulasi', [LayerController::class, 'getPopulasi'])->name('getPopulasi');
    Route::get('/getPakan', [LayerController::class, 'getPakan'])->name('getPakan');
    Route::get('/getPersen', [LayerController::class, 'getPersen'])->name('getPersen');
    Route::get('/getSatuanPakan', [LayerController::class, 'getSatuanPakan'])->name('getSatuanPakan');
    Route::get('/getSatuanAir', [LayerController::class, 'getSatuanAir'])->name('getSatuanAir');
    Route::get('/getSatuanObatAyam', [LayerController::class, 'getSatuanObatAyam'])->name('getSatuanObatAyam');
    Route::post('/editTelur', [LayerController::class, 'editTelur'])->name('editTelur');
    Route::post('/inputPerencanaan', [LayerController::class, 'inputPerencanaan'])->name('inputPerencanaan');
    Route::get('/viewHistoryPerencanaan', [LayerController::class, 'viewHistoryPerencanaan'])->name('viewHistoryPerencanaan');
    Route::get('/viewHistoryStok', [LayerController::class, 'viewHistoryStok'])->name('viewHistoryStok');
    Route::get('/viewHistoryPullet', [LayerController::class, 'viewHistoryPullet'])->name('viewHistoryPullet');
    Route::get('/viewHistoryEditPerencanaan', [LayerController::class, 'viewHistoryEditPerencanaan'])->name('viewHistoryEditPerencanaan');
    Route::post('/editPerencanaan', [LayerController::class, 'editPerencanaan'])->name('editPerencanaan');
    
    // export
    Route::get('/export', [ExportController::class, 'export'])->name('export');
    Route::post('/exportDaily', [ExportController::class, 'exportDaily'])->name('exportDaily');
    Route::post('/laporanLayer', [ExportController::class, 'laporanLayer'])->name('laporanLayer');
    Route::get('/exportObat', [ExportController::class, 'exportObat'])->name('exportObat');

    // LAYER VIEW
    Route::get('/tambah_pakan', function(Request $r){
        return view('layer.tambahView.tambahPakan',['c' => $r->c]);
    })->name('tambah_pakan');

    Route::get('/tambah_obatPakan', function(Request $r){
        return view('layer.tambahView.tambahObatPakan',['c' => $r->c]);
    })->name('tambah_obatPakan');

    Route::get('/tambah_obatAir', function(Request $r){
        return view('layer.tambahView.tambahObatAir',['c' => $r->c]);
    })->name('tambah_obatAir');

    Route::get('/tambah_pupuk', function(Request $r){
        return view('layer.tambahView.tambahPupuk',['c' => $r->c]);
    })->name('tambah_pupuk');

    Route::get('/tambah_telur', function(Request $r){
        return view('layer.tambahView.tambahTelur',['c' => $r->c]);
    })->name('tambah_telur');
    
    Route::get('/tambah_populasi', function(Request $r){
        return view('layer.tambahView.tambahPopulasi',['c' => $r->c]);
    })->name('tambah_populasi');

    // email cornjob
    Route::get('/emailTelur', function(Request $r){
        $email = User::where('email_notif', 'Y')->get();
        $tgl1 = date('Y-m-01');
        $tgl2 = date('Y-m-d');

        foreach($email as $e) {
            Mail::to($e->email)->send(new EmailTelur($tgl1, $tgl2));
        }
        dd('Berhasil');

    });
    
    Route::get('/telur', function(Request $r){
        $tgl1 = $r->tgl1 ?? date('Y-m-01');
        $tgl2 = $r->tgl2 ?? date('Y-m-d');

        $tgl = DB::select("SELECT a.tgl, b.nm_kandang, TIMESTAMPDIFF(WEEK, b.tgl_masuk , a.tgl) AS mgg, SUM(a.pcs) as ttl_pcs FROM tb_telur as a
        LEFT JOIN tb_kandang as b ON a.id_kandang = b.id_kandang
        WHERE b.selesai = 'T' AND a.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP by a.tgl;");

        $kandang = DB::select("SELECT a.id_kandang, a.nm_kandang, TIMESTAMPDIFF(WEEK, a.tgl_masuk , '$tgl2') AS mgg, b.populasi, b.death, b.culling FROM tb_kandang as a
        LEFT JOIN tb_populasi as b ON a.id_kandang = b.id_kandang AND b.tgl = '$tgl2'
        WHERE a.selesai = 'T'");
   
        $data = [
            'title' => 'Email Bulan',
            'tgl' => $tgl,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'kandang' => $kandang
        ];

        return view('cornjob.cornjob', $data);
    });

    // ------------------------
   
    
    // kandang
    Route::get('/kandang', [LayerController::class, 'kandang'])->name('kandang');
    Route::post('/addKandang', [LayerController::class, 'addKandang'])->name('addKandang');
    Route::get('/editModalKandang', [LayerController::class, 'editModalKandang'])->name('editModalKandang');
    Route::post('/editKandang', [LayerController::class, 'editKandang'])->name('editKandang');
    Route::get('/status/{tipe}/{id_kandang}', [LayerController::class, 'status'])->name('status');

    // obat
    Route::get('/obat', [LayerController::class, 'obat'])->name('obat');
    Route::post('/addObat', [LayerController::class, 'addObat'])->name('addObat');
    Route::get('/editModalObat', [LayerController::class, 'editModalObat'])->name('editModalObat');
    Route::post('/editObat', [LayerController::class, 'editObat'])->name('editObat');
    Route::get('/deleteObat/{id}', [LayerController::class, 'deleteObat'])->name('deleteObat');
    
    // pakan
    Route::get('/pakan', [LayerController::class, 'pakan'])->name('pakan');
    Route::post('/addPakan', [LayerController::class, 'addPakan'])->name('addPakan');
    Route::get('/editModalPakan', [LayerController::class, 'editModalPakan'])->name('editModalPakan');
    Route::post('/editPakan', [LayerController::class, 'editPakan'])->name('editPakan');
    Route::get('/deletePakan/{id}', [LayerController::class, 'deletePakan'])->name('deletePakan');
    
    // Penjualan
    Route::get('/penjualanTelur', [PenjualanTelurController::class, 'index'])->name('penjualanTelur');
    Route::get('/viewDetail', [PenjualanTelurController::class, 'viewDetail'])->name('viewDetail');
    Route::post('/addPenjualan', [PenjualanTelurController::class, 'addPenjualan'])->name('addPenjualan');
    Route::get('/editModalPenjualan', [PenjualanTelurController::class, 'editModalPenjualan'])->name('editModalPenjualan');
    Route::post('/editPenjualan', [PenjualanTelurController::class, 'editPenjualan'])->name('editPenjualan');
    Route::get('/deletePenjualan/{id}', [PenjualanTelurController::class, 'deletePenjualan'])->name('deletePenjualan');
    Route::post('/pemutihanPenjualan', [PenjualanTelurController::class, 'pemutihanPenjualan'])->name('pemutihanPenjualan');
    
    
    // solar
    Route::get('/solar', [SolarController::class, 'solar'])->name('solar');
    Route::post('/addSolar', [SolarController::class, 'addSolar'])->name('addSolar');
    Route::get('/editModalSolar', [SolarController::class, 'editModalSolar'])->name('editModalSolar');
    Route::post('/editSolar', [SolarController::class, 'editSolar'])->name('editSolar');
    Route::get('/deleteSolar/{id}', [SolarController::class, 'deleteSolar'])->name('deleteSolar');

    // rak
    Route::get('/rakTelur', [RakTelurController::class, 'rakTelur'])->name('rakTelur');
    Route::post('/addRakTelur', [RakTelurController::class, 'addRakTelur'])->name('addRakTelur');
    Route::get('/editModalRakTelur', [RakTelurController::class, 'editModalRakTelur'])->name('editModalRakTelur');
    Route::post('/editRakTelur', [RakTelurController::class, 'editRakTelur'])->name('editRakTelur');
    Route::get('/deleteRakTelur/{id}', [RakTelurController::class, 'deleteRakTelur'])->name('deleteRakTelur');

    // kirim ayam
    Route::get('/kirimAyam', [KirimAyamController::class, 'index'])->name('kirimAyam');
    Route::post('/tambahAyam', [KirimAyamController::class, 'tambahAyam'])->name('tambahAyam');
    Route::post('/editAyam', [KirimAyamController::class, 'editAyam'])->name('editAyam');
    Route::get('/deleteAyam/{id}', [KirimAyamController::class, 'deleteAyam'])->name('deleteAyam');
    Route::get('/editModalAyam', [KirimAyamController::class, 'editModalAyam'])->name('editModalAyam');
    
    // Performa
    Route::get('/performa/{kategori}', [PerformaController::class, 'index'])->name('performa');
    Route::get('/editModalPerforma', [PerformaController::class, 'editModalPerforma'])->name('editModalPerforma');
    Route::post('/addPerforma', [PerformaController::class, 'addPerforma'])->name('addPerforma');
    Route::post('/editPerforma', [PerformaController::class, 'editPerforma'])->name('editPerforma');
    Route::get('/deletePerforma/{id}/{kategori}', [PerformaController::class, 'deletePerforma'])->name('deletePerforma');
    
    // data user ---------------------
    // email
    Route::get('/email', [EmailController::class, 'email'])->name('email');
    Route::post('/addEmail', [EmailController::class, 'addEmail'])->name('addEmail');
    Route::get('/editModalEmail', [EmailController::class, 'editModalEmail'])->name('editModalEmail');
    Route::post('/editEmail', [EmailController::class, 'editEmail'])->name('editEmail');
    Route::get('/deleteEmail/{id}', [EmailController::class, 'deleteEmail'])->name('deleteEmail');
    
    
    Route::get('/user', [UserController::class, 'user'])->name('user');
    Route::post('/addUser', [UserController::class, 'addUser'])->name('addUser');
    Route::get('/editModalUser', [UserController::class, 'editModalUser'])->name('editModalUser');
    Route::post('/editUser', [UserController::class, 'editUser'])->name('editUser');
    Route::get('/deleteUser/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::get('/emailNotif/{id}/{status}', [UserController::class, 'emailNotif'])->name('emailNotif');
});

Auth::routes();
