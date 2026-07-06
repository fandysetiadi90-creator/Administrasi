<?php

namespace App\Http\Controllers;

use App\Models\KelasModel;
use App\Models\PenggunaModel;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = KelasModel::with('pengguna')->get();

        return view('kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil id_pengguna yang sudah menjadi wali kelas
        $sudahPunyaKelas = KelasModel::pluck('id_pengguna');

        // Ambil pengguna dengan jabatan Wali Kelas
        // yang belum menjadi wali kelas di tabel kelas
        $pengguna = PenggunaModel::where('jabatan', 'Wali Kelas')
            ->whereNotIn('id_pengguna', $sudahPunyaKelas)
            ->get();

        return view('kelas.create', compact('pengguna'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required',
            'nama' => 'required|string|max:6',
            'fase' => 'nullable|string|max:10',
            'deskripsi' => 'nullable',
        ]);

        // cek apakah benar wali kelas
        $pengguna = PenggunaModel::where('id_pengguna', $request->id_pengguna)
            ->where('jabatan', 'wali kelas')
            ->first();

        if (!$pengguna) {
            return back()->with('error', 'Pengguna yang dipilih bukan wali kelas');
        }

        KelasModel::create([
            'id_pengguna' => $request->id_pengguna,
            'nama' => $request->nama,
            'fase' => $request->fase,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelas = KelasModel::with('pengguna')
            ->findOrFail($id);

        return view('kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelas = KelasModel::findOrFail($id);

        // hanya tampilkan wali kelas
        $pengguna = PenggunaModel::where('jabatan', 'wali kelas')->get();

        return view('kelas.edit', compact('kelas', 'pengguna'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_pengguna' => 'required',
            'nama' => 'required|max:6',
            'fase' => 'nullable|max:10',
            'deskripsi' => 'nullable',
        ]);

        // cek apakah benar wali kelas
        $pengguna = PenggunaModel::where('id_pengguna', $request->id_pengguna)
            ->where('jabatan', 'wali kelas')
            ->first();

        if (!$pengguna) {
            return back()->with('error', 'Pengguna yang dipilih bukan wali kelas');
        }

        $kelas = KelasModel::findOrFail($id);

        $kelas->update([
            'id_pengguna' => $request->id_pengguna,
            'nama' => $request->nama,
            'fase' => $request->fase,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kelas.index')
            ->with('success', 'Data kelas berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = KelasModel::findOrFail($id);

        $kelas->delete();

        return redirect()->route('kelas.index')
            ->with('success', 'Data kelas berhasil dihapus');
    }
}
