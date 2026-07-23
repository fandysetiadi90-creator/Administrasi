<?php

namespace App\Http\Controllers;

use App\Models\PeriodeModel;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{

    public function index()
    {
        $periode = PeriodeModel::latest()->get();

        return view('periode.index', compact('periode'));
    }

    public function create()
    {
        return view('periode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
            'semester'     => 'required',
            'status'       => 'required',
        ]);

        // Jika periode baru aktif,
        // nonaktifkan semua periode sebelumnya
        if ($request->status == 'Aktif') {
            PeriodeModel::query()->update([
                'status' => 'Nonaktif'
            ]);
        }

        PeriodeModel::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester'     => $request->semester,
            'status'       => $request->status,
        ]);

        return redirect()
            ->route('periode.index')
            ->with('success', 'Data periode berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $periode = PeriodeModel::findOrFail($id);

        return view('periode.show', compact('periode'));
    }

    public function edit(string $id)
    {
        $periode = PeriodeModel::findOrFail($id);

        return view('periode.edit', compact('periode'));
    }

    public function update(Request $request, string $id)
    {
        $periode = PeriodeModel::findOrFail($id);

        $request->validate([
            'tahun_ajaran' => 'required',
            'semester'     => 'required',
            'status'       => 'required',
        ]);

        // Jika periode yang diedit menjadi aktif,
        // nonaktifkan semua periode lainnya
        if ($request->status == 'Aktif') {
            PeriodeModel::where('id_periode', '!=', $id)
                ->update([
                    'status' => 'Nonaktif'
                ]);
        }

        $periode->update([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester'     => $request->semester,
            'status'       => $request->status,
        ]);

        return redirect()
            ->route('periode.index')
            ->with('success', 'Data periode berhasil diperbarui');
    }

    public function destroy($id)
    {
        $periode = PeriodeModel::findOrFail($id);

        // Cek status aktif
        if ($periode->status == 'Aktif') {
            return back()->with('error', 'Periode aktif tidak dapat dihapus.');
        }

        // Cek apakah sudah digunakan administrasi
        if ($periode->administrasi()->exists()) {
            return back()->with('error', 'Periode tidak dapat dihapus karena sudah digunakan.');
        }

        $periode->delete();

        return back()->with('success', 'Data periode berhasil dihapus.');
    }
}
