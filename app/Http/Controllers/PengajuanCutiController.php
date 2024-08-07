<?php

namespace App\Http\Controllers;

use App\Models\JatahCuti;
use App\Models\PengajuanCuti;
use App\Models\PersetujuanPertama;
use App\Models\PersetujuanKedua;
use App\Models\Atasan;
use App\Models\Kelompok;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // return PengajuanCuti::where('NIP', Auth::guard('pegawai')->user()->NIP)->get();
        return view('dashboardPengajuanCuti.index', [
            'jatahCutis' => JatahCuti::where('NIP', Auth::guard('pegawai')->user()->NIP)->orderByDesc('created_at')->get(),
            'pengajuanCutis' => PengajuanCuti::where('NIP', Auth::guard('pegawai')->user()->NIP)->orderByDesc('created_at')->get()
        ]);
    }

  

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $jenisCuti = [
            'cuti tahunan',
            'cuti sakit',
            'cuti alasan penting',
            'cuti besar',
            'cuti melahirkan',
            'cuti diluar tanggungan negara',
        ];

        return view('dashboardPengajuanCuti.create', [
            'jenisCutis' => $jenisCuti
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'NIP' => 'required',
            'nama_kelompok' => 'required',
            'jenis_cuti' => 'required|max:50',
            'alasan' => 'required',
            'tanggal_mulai_cuti' => 'required',
            'tanggal_akhir_cuti' => 'required',
            'alamat_cuti' => 'required',
            'file' => 'max:5000'
        ]);

        if ($request->file('file')) {
            // get file : 
            $file = $request->file('file');

            $renameNamaFile = uniqid() . '_' . $file->getClientOriginalName();

            $validated['file'] = $renameNamaFile;

            $tujuan_upload = 'file';

            $file->move($tujuan_upload, $renameNamaFile);
        }

        // mengecek selisih hari
        $tanggalMulai = date_create($request->tanggal_mulai_cuti);
        $tanggalAkhir = date_create($request->tanggal_akhir_cuti);

        $jumlahCuti = date_diff($tanggalMulai, $tanggalAkhir);
        $jumlahCuti = $jumlahCuti->days + 1;

        // ambil data jatah cuti berdasarkan 3 tahun yang lalu :
        $tahunSekarang = date('Y');
        $tahunSekarang = intval($tahunSekarang);
        $duaTahunLalu = $tahunSekarang - 2;

        $dataJatahCuti = JatahCuti::where('NIP', Auth::guard('pegawai')->user()->NIP)->whereBetween('tahun', [$duaTahunLalu, $tahunSekarang])->get();

        $sisaLiburan = 0;
        foreach ($dataJatahCuti as $sisa) {
            $sisaLiburan += $sisa->jatah;
        }
        // filter Jenis Cuti
        if ($request->jenis_cuti == 'cuti tahunan'){
        // bandingkan hari dan buat eror
        if ($jumlahCuti > $sisaLiburan) {
            return back()->with('errorJumlahCuti', 'Jumlah Cuti Melewati Batas');
        }
    }

        // tambah data pengajuan cuti :
        $getDataPengajuanCuti = PengajuanCuti::create($validated);



        // tambah data persetujuan pertama :
        // cek apakah kelompok balai : 
        // jika balai maka set $dataPersetujuanPertama 'status' == setuju, dan keterangan diterima : 

        if ($validated['nama_kelompok'] == 'KTU') {

            $dataPersetujuanPertama = [
                'pengajuan_cuti_id' => $getDataPengajuanCuti->id,
                'kelompok' => Auth::guard('pegawai')->user()->nama_kelompok,
                'status' => 'setuju',
                'keterangan' => 'diterima'
            ];

            $getDataPersetujuanPertama = PersetujuanPertama::create($dataPersetujuanPertama);

            // buat persetujuan kedua langsung : 
            PersetujuanKedua::create(['persetujuan_pertama_id' => $getDataPersetujuanPertama->id]);
        } else {
            // jika bukan balai : 
            $dataPersetujuanPertama = [
                'pengajuan_cuti_id' => $getDataPengajuanCuti->id,
                'kelompok' => Auth::guard('pegawai')->user()->nama_kelompok
            ];

            PersetujuanPertama::create($dataPersetujuanPertama);
        }

        return redirect('dashboard/pengajuancuti')->with('success', 'Pengajuan cuti berhasil diajukan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(pengajuanCuti $pengajuancuti)
{
    // $pengajuancuti = PengajuanCuti::findOrFail($id);
    $getDataPegawai = Pegawai::where('NIP', $pengajuancuti->NIP)->first();

    return view('dashboardPengajuanCuti.show', [
        'pengajuanCuti' => $pengajuancuti,
        'getDataPegawai' => $getDataPegawai,
        'persetujuanPertama'=>$pengajuancuti->persetujuanPertama,
        'persetujuanKedua'=>$pengajuancuti->persetujuanPertama->persetujuanKedua
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanCuti $pengajuanCuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanCuti $pengajuanCuti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanCuti $pengajuanCuti)
    {
        //
    }

    public function cetakcuti(PengajuanCuti $data)
    {
        // dapatkan data ketua balai : 
        $dataKetuaBalai = Atasan::where('nama_kelompok', 'KTU')->first();

        // dapatkan data kelompok dari nama kelompok : 
        $dataKelompok = Kelompok::where('nama_kelompok', $data->nama_kelompok)->first();
        $dataKetuaKelompok = $dataKelompok->dataKetua;

        // data persetujuan pertama : 
        $dataPersetujuanPertama = $data->persetujuanPertama;

        // data persetujuan kedua : 
        $dataPersetujuanKedua = $dataPersetujuanPertama->persetujuanKedua;

        // ambil data jatah cuti berdasarkan 3 tahun yang lalu :
        $tahunSekarang = date('Y');
        $tahunSekarang = intval($tahunSekarang);
        $duaTahunLalu = $tahunSekarang - 2;

        // dapatkan data selisih hari : 
        $tanggal_mulai_cuti = date_create($data->tanggal_mulai_cuti);
        $tanggal_akhir_cuti = date_create($data->tanggal_akhir_cuti);
        $jumlahCuti = date_diff($tanggal_mulai_cuti, $tanggal_akhir_cuti);
        $jumlahCuti = $jumlahCuti->days + 1;

        return view('dashboardPengajuanCuti.cetak', [
            'pengajuanCuti' => $data,
            'jatahCutiDuaTahunLalu' => JatahCuti::where('NIP', Auth::guard('pegawai')->user()->NIP)->where('tahun', ($duaTahunLalu))->first(),
            'jatahCutiSatuTahunLalu' => JatahCuti::where('NIP', Auth::guard('pegawai')->user()->NIP)->where('tahun', ($duaTahunLalu + 1))->first(),
            'jatahCutiTahunSekarang' => JatahCuti::where('NIP', Auth::guard('pegawai')->user()->NIP)->where('tahun', $tahunSekarang)->first(),
            'dataKetuaKelompok' => $dataKetuaKelompok,
            'dataPersetujuanPertama' => $dataPersetujuanPertama,
            'dataPersetujuanKedua' => $dataPersetujuanKedua,
            'dataKetuaBalai' => $dataKetuaBalai,
            'jumlahCuti' => $jumlahCuti
        ]);
    }

    public function cetaksurat(PengajuanCuti $data)
    {

        // ambil data ketua kelompok : 
        $dataAtasan = Atasan::where('nama_kelompok', $data->nama_kelompok)->first();

        // dapatkan data selisih hari : 
        $tanggal_mulai_cuti = date_create($data->tanggal_mulai_cuti);
        $tanggal_akhir_cuti = date_create($data->tanggal_akhir_cuti);
        $jumlahCuti = date_diff($tanggal_mulai_cuti, $tanggal_akhir_cuti);
        $jumlahCuti = $jumlahCuti->days + 1;

        return view(
            'dashboardPengajuanCuti.cetaksurat',
            [
                'pengajuanCuti' => $data,
                'dataDiri' => Auth::guard('pegawai')->user(),
                'jumlahCuti' => $jumlahCuti,
                'dataAtasan' => $dataAtasan
            ]
        );
    }

    public function cetakSuratAdmin(PengajuanCuti $data)
    {
        // ambil data ketua kelompok : 
        $dataAtasan = Atasan::where('nama_kelompok', $data->nama_kelompok)->first();

        // dapatkan data selisih hari : 
        $tanggal_mulai_cuti = date_create($data->tanggal_mulai_cuti);
        $tanggal_akhir_cuti = date_create($data->tanggal_akhir_cuti);
        $jumlahCuti = date_diff($tanggal_mulai_cuti, $tanggal_akhir_cuti);
        $jumlahCuti = $jumlahCuti->days + 1;

        $dataDiri = Pegawai::where('NIP', $data->NIP)->first();

        return view(
            'dashboardPengajuanCuti.cetaksurat',
            [
                'pengajuanCuti' => $data,
                'dataDiri' => $dataDiri,
                'jumlahCuti' => $jumlahCuti,
                'dataAtasan' => $dataAtasan
            ]
        );
    }

    public function cetakFormAdmin(PengajuanCuti $data)
    {
        // dapatkan data ketua balai : 
        $dataKetuaBalai = Atasan::where('nama_kelompok', 'KTU')->first();

        // dapatkan data kelompok dari nama kelompok : 
        $dataKelompok = Kelompok::where('nama_kelompok', $data->nama_kelompok)->first();
        $dataKetuaKelompok = $dataKelompok->dataKetua;

        // data persetujuan pertama : 
        $dataPersetujuanPertama = $data->persetujuanPertama;

        // data persetujuan kedua : 
        $dataPersetujuanKedua = $dataPersetujuanPertama->persetujuanKedua;

        // ambil data jatah cuti berdasarkan 3 tahun yang lalu :
        $tahunSekarang = date('Y');
        $tahunSekarang = intval($tahunSekarang);
        $duaTahunLalu = $tahunSekarang - 2;

        // dapatkan data selisih hari : 
        $tanggal_mulai_cuti = date_create($data->tanggal_mulai_cuti);
        $tanggal_akhir_cuti = date_create($data->tanggal_akhir_cuti);
        $jumlahCuti = date_diff($tanggal_mulai_cuti, $tanggal_akhir_cuti)->days + 1;

        return view('dashboardPengajuanCuti.lihatFormAdmin', [
            'pengajuanCuti' => $data,
            'jatahCutiDuaTahunLalu' => JatahCuti::where('NIP', $data->NIP)->where('tahun', $duaTahunLalu)->orderByDesc('created_at')->first(),
            'jatahCutiSatuTahunLalu' => JatahCuti::where('NIP', $data->NIP)->where('tahun', ($duaTahunLalu + 1))->orderByDesc('created_at')->first(),
            'jatahCutiTahunSekarang' => JatahCuti::where('NIP', $data->NIP)->where('tahun', $tahunSekarang)->orderByDesc('created_at')->first(),
            'dataKetuaKelompok' => $dataKetuaKelompok,
            'dataPersetujuanPertama' => $dataPersetujuanPertama,
            'dataPersetujuanKedua' => $dataPersetujuanKedua,
            'dataKetuaBalai' => $dataKetuaBalai,
            'jumlahCuti' => $jumlahCuti,
            'pegawai' => $data->pegawai
        ]);
    
    }

    

    public function laporan(Request $request)
    {
        $dataPengajuanCuti = PengajuanCuti::whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir])->orderBy('created_at', 'DESC')->get();

        return view('laporan', [
            'dataPengajuanCuti' => $dataPengajuanCuti,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir
        ]);
    }

    public function lihatPengajuanCuti()
    {

        return view('dashboardPengajuanCuti.lihat', [
            'pengajuanCutis' => PengajuanCuti::all()
        ]);
    }

    
    
    
}







