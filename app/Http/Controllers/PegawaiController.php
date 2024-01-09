<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboardCrudPegawai.index', [
            'pegawais' => Pegawai::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboardCrudPegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'NIP' => 'required|max:18|min:18|unique:pegawais',
            'nama' => 'required|max:255',
            'jabatan' => 'required',
            'masa_kerja' => 'required|max:3'
        ]);

        Pegawai::create($validated);

        return redirect('/datapegawai')->with('success', 'Data pegawai berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $datapegawai)
    {

        return view('dashboardCrudPegawai.edit', [
            'pegawai' => $datapegawai
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $datapegawai)
    {
        $rules = [
            'nama' => 'required|max:255',
            'jabatan' => 'required',
            'masa_kerja' => 'required|max:3'
        ];

        if ($request->NIP != $datapegawai->NIP) {
            $rules['NIP'] = 'required|max:18|min:18|unique:pegawais';
        }

        $validated = $request->validate($rules);

        Pegawai::where('id', $datapegawai->id)
            ->update($validated);

        return redirect('/datapegawai')->with('success', 'Data pegawai berhasil dirubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $datapegawai)
    {
        Pegawai::destroy($datapegawai->id);

        return redirect('/datapegawai')->with('success', 'Data pegawai berhasil dihapus!');
    }
}
