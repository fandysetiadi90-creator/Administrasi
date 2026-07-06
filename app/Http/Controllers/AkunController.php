<?php

namespace App\Http\Controllers;

use App\Models\AkunModel;
use App\Models\PenggunaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $data = AkunModel::with('pengguna')->get();
        return view('akun.index', compact('data'));
    }

    public function create()
    {
        $pengguna = PenggunaModel::whereDoesntHave('akun')->get();

        return view('akun.create', compact('pengguna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|unique:akun,id_pengguna',
            'password' => 'required|min:6',
        ]);

        AkunModel::create([
            'id_pengguna' => $request->id_pengguna,
            'password' => Hash::make($request->password), // 🔥 HASH
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dibuat');
    }

    public function edit($id)
    {
        $akun = AkunModel::findOrFail($id);
        $pengguna = PenggunaModel::all();

        return view('akun.edit', compact('akun', 'pengguna'));
    }

    public function update(Request $request, $id)
    {
        $akun = AkunModel::findOrFail($id);

        if ($request->password) {
            $akun->update([
                'password' => Hash::make($request->password),
            ]);
        }
        
        return redirect()->route('akun.index')->with('success', 'Password berhasil diupdate');
    }

    public function destroy($id)
    {
        $akun = AkunModel::findOrFail($id);
        $akun->delete();

        return redirect()->route('akun.index')->with('success', 'Akun dihapus');
    }
}
