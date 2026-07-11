<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Ambil kelas berdasarkan wali kelas yang login
        $kelas = KelasModel::where('id_pengguna', $user->id_pengguna)->first();

        // Jika belum memiliki kelas
        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas.');
        }

        // Ambil siswa berdasarkan kelas
        $siswa = SiswaModel::where('id_kelas', $kelas->id_kelas)
            ->orderBy('nama', 'asc')
            ->get();

        return view('siswa.index', compact('siswa', 'kelas'));
    }

    public function create()
    {
        $user = Auth::user();

        $kelas = KelasModel::where('id_pengguna', $user->id_pengguna)->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum memiliki kelas.');
        }

        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|max:60',
            'nis'           => 'required|max:30|unique:siswa,nis',
            'tempat_lahir'  => 'required|max:25',
            'tgl_lahir'     => 'required|date',
            'agama'         => 'required|max:12',
            'alamat'        => 'required',
        ]);

        $user = Auth::user();

        // Ambil kelas berdasarkan user login
        $kelas = KelasModel::where('id_pengguna', $user->id_pengguna)->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan.');
        }

        // Simpan siswa otomatis ke kelas wali kelas login
        SiswaModel::create([
            'id_kelas'      => $kelas->id_kelas,
            'nama'          => $request->nama,
            'nis'           => $request->nis,
            'tempat_lahir'  => $request->tempat_lahir,
            'tgl_lahir'     => $request->tgl_lahir,
            'agama'         => $request->agama,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Detail siswa
     */
    public function show($id)
    {
        $siswa = SiswaModel::with('kelas')->findOrFail($id);

        return view('siswa.show', compact('siswa'));
    }

    /**
     * Form edit siswa
     */
    public function edit($id)
    {
        $siswa = SiswaModel::findOrFail($id);

        return view('siswa.edit', compact('siswa'));
    }

    /**
     * Update siswa
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'          => 'required|max:60',
            'nis'           => 'required|max:30|unique:siswa,nis,' . $id . ',id_siswa',
            'tempat_lahir'  => 'required|max:25',
            'tgl_lahir'     => 'required|date',
            'agama'         => 'required|max:12',
            'alamat'        => 'required',
        ]);

        $siswa = SiswaModel::findOrFail($id);

        $siswa->update([
            'nama'          => $request->nama,
            'nis'           => $request->nis,
            'tempat_lahir'  => $request->tempat_lahir,
            'tgl_lahir'     => $request->tgl_lahir,
            'agama'         => $request->agama,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $siswa = SiswaModel::findOrFail($id);

        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
