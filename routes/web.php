<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengajuanCutiController;
use App\Http\Controllers\AtasanController;
use App\Http\Controllers\JatahCutiController;
use App\Http\Controllers\PersetujuanKeduaController;
use App\Http\Controllers\PersetujuanPertamaController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('auth:user');

Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::resource('dashboard/datapegawai', PegawaiController::class)->middleware('auth:user');
Route::resource('dashboard/dataatasan', AtasanController::class)->middleware('auth:user');

Route::middleware('auth:user')->group(function () {
    Route::get('dashboard/surat', [SuratController::class, 'index']);
    Route::get('dashboard/surat/{data}/show', [SuratController::class, 'show']);
    Route::post('dashboard/surat', [SuratController::class, 'store']);
    Route::post('dashboard/laporan', [PengajuanCutiController::class, 'laporan']);
    Route::get('dashboard/cetaksuratadmin/{data}', [PengajuanCutiController::class, 'cetakSuratAdmin']);
    Route::get('dashboard/cetakformadmin/{data}', [PengajuanCutiController::class, 'cetakFormAdmin']);
    Route::get('dashboard/lihatpengajuancuti', [PengajuanCutiController::class, 'lihatPengajuanCuti']);

    // lihat jatah cuti : 
    Route::get('dashboard/datacuti/{data}', [PegawaiController::class, 'datacuti']);
    Route::get('dashboard/jatah/{data}/edit', [JatahCutiController::class, 'edit']);
    Route::post('dashboard/jatah/{data}', [JatahCutiController::class, 'update']);
    Route::get('dashboard/tambahjatahtahunan', [JatahCutiController::class, 'tambahJatahTahunan']);
});

Route::middleware('auth:pegawai')->group(function () {
    Route::resource('dashboard/pengajuancuti', PengajuanCutiController::class);
    Route::get('dashboard/cetakcuti/{data}', [PengajuanCutiController::class, 'cetakcuti']);
    Route::get('dashboard/cetaksurat/{data}', [PengajuanCutiController::class, 'cetaksurat']);
});



Route::middleware('auth:atasan')->group(function () {
    Route::get('dashboard/persetujuanpertama', [PersetujuanPertamaController::class, 'index']);
    Route::get('dashboard/persetujuanpertama/{data}/show', [PersetujuanPertamaController::class, 'show']);
    Route::post('dahsboard/persetujuanpertama/{data}', [PersetujuanPertamaController::class, 'persetujuan']);
});

Route::middleware('auth:atasan')->group(function () {
    Route::get('dahsboard/persetujuankedua', [PersetujuanKeduaController::class, 'index']);
    Route::get('dashboard/persetujuankedua/{data}/show', [PersetujuanKeduaController::class, 'show']);
    Route::post('dashboard/persetujuankedua/{data}', [PersetujuanKeduaController::class, 'persetujuan']);
});

Route::get('dashboard/persetujuan', function () {
    return view('dashboardCuti.index');
});

Route::get('dashboard/cuti', function () {
    return view('dashboardCuti.index');
});

Route::get('/test', function () {
    return Auth::guard('user')->user()->name;
});

Route::get('/test2', function () {
    return Auth::guard('pegawai')->user()->nama;
});

Route::get('/test3', function () {
    return Auth::guard('atasan')->user()->nama;
});

Route::get('/test4', function () {
    dd(Auth::guard()->check());
});

Route::get('/logoutt', function () {
    Auth::guard('pegawai')->logout();
    Auth::guard('user')->logout();
    Auth::guard('atasan')->logout();
    return redirect('/login');
});
