<?php

namespace App\Http\Controllers;

use App\Models\PenggunaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class PenggunaController extends Controller
{
    public function index()
    {
        $data = PenggunaModel::all();
        return view('pengguna.index', compact('data'));
    }

    public function create()
    {
        $adminExists = PenggunaModel::where('jabatan', 'Admin')->exists();
        $kepsekExists = PenggunaModel::where('jabatan', 'Kepala Sekolah')->exists();
        return view('pengguna.create', compact('adminExists', 'kepsekExists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:pengguna,email',
            'nama' => ['required', 'regex:/^[a-zA-Z\s\'.-,]+$/'],
            'nomor_induk' => ['required', 'numeric'],       
            'jabatan' => 'required|in:Admin,Kepala Sekolah,Wali Kelas',
            'poto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'nama.regex' => 'Nama hanya boleh berisi huruf, spasi, dan tanda baca.',    
                'nomor_induk.required' => 'Nomor Induk wajib diisi.',
                'nomor_induk.numeric' => 'Nomor Induk hanya boleh berisi angka.',
            
        ]);

        // CEK JABATAN TIDAK BOLEH DOBEL
        if (in_array($request->jabatan, ['Admin', 'Kepala Sekolah'])) {
            $exists = PenggunaModel::where('jabatan', $request->jabatan)->exists();

            if ($exists) {
                return back()->withErrors([
                    'jabatan' => $request->jabatan . ' sudah ada, tidak boleh lebih dari satu!'
                ])->withInput();
            }
        }

        // simpan dulu tanpa foto
        $pengguna = PenggunaModel::create([
            'email' => $request->email,
            'nama' => $request->nama,
            'nomor_induk' => $request->nomor_induk,
            'jabatan' => $request->jabatan,
        ]);

        // upload foto jika ada
        if ($request->hasFile('poto')) {
            $file = $request->file('poto');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            Storage::disk('public')->putFileAs(
                'poto/' . $pengguna->id_pengguna,
                $file,
                $filename
            );

            $pengguna->update([
                'poto' => $pengguna->id_pengguna . '/' . $filename
            ]);
        }

        return redirect()->route('pengguna.index')->with('success', 'Data berhasil ditambah');
    }

   public function edit($id)
    {
        if (Auth::user()->jabatan != 'Admin' &&
            Auth::user()->id_pengguna != $id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $pengguna = PenggunaModel::findOrFail($id);

        return view('pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->jabatan != 'Admin' &&
            Auth::user()->id_pengguna != $id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $pengguna = PenggunaModel::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:pengguna,email,' . $id . ',id_pengguna',
            'nama' => ['required', 'regex:/^[a-zA-Z\s\'.-,]+$/'],
            'nomor_induk' => ['required', 'numeric'],       
            'jabatan' => 'required|in:Admin,Kepala Sekolah,Wali Kelas',
            'poto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'nama.regex' => 'Nama hanya boleh berisi huruf, spasi, dan tanda baca.',        
                'nomor_induk.required' => 'Nomor Induk wajib diisi.',
                'nomor_induk.numeric' => 'Nomor Induk hanya boleh berisi angka.',
                
        ]);

        // Admin dan Kepala Sekolah hanya boleh satu
        if (in_array($request->jabatan, ['Admin', 'Kepala Sekolah'])) {

            $exists = PenggunaModel::where('jabatan', $request->jabatan)
                ->where('id_pengguna', '!=', $id)
                ->exists();

            if ($exists) {
                return back()->withErrors([
                    'jabatan' => $request->jabatan . ' sudah ada, tidak boleh lebih dari satu!'
                ])->withInput();
            }
        }

        $data = [
            'email' => $request->email,
            'nama' => $request->nama,
            'nomor_induk' => $request->nomor_induk,
            'jabatan' => $request->jabatan,
        ];

        // Upload foto baru
        if ($request->hasFile('poto')) {

            // Hapus foto lama
            if ($pengguna->poto && Storage::disk('public')->exists('poto/' . $pengguna->poto)) {
                Storage::disk('public')->delete('poto/' . $pengguna->poto);
            }

            $file = $request->file('poto');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            Storage::disk('public')->putFileAs(
                'poto/' . $pengguna->id_pengguna,
                $file,
                $filename
            );

            $data['poto'] = $pengguna->id_pengguna . '/' . $filename;
        }

        $pengguna->update($data);

        // Redirect sesuai hak akses
        if (Auth::user()->jabatan == 'Admin') {
            return redirect()
                ->route('pengguna.index')
                ->with('success', 'Data pengguna berhasil diperbarui.');
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengguna = PenggunaModel::findOrFail($id);

        // TIDAK BOLEH HAPUS kalau masih punya akun
        if ($pengguna->akun()->exists()) {
            return redirect()->back()->with('error', 'Data tidak bisa dihapus karena masih memiliki akun!');
        }

        // hapus foto jika ada
        if ($pengguna->poto && Storage::exists('public/poto/' . $pengguna->poto)) {
            Storage::delete('public/poto/' . $pengguna->poto);
        }

        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Data berhasil dihapus');
    }
}
