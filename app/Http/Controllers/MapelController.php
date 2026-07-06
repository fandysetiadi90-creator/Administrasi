<?php

namespace App\Http\Controllers;

use App\Models\MapelModel;
use Illuminate\Http\Request;

class MapelController extends Controller
{

    public function index()
    {
        $mapel = MapelModel::latest()->get();

        return view('mapel.index', compact('mapel'));
    }

    public function create()
    {
        return view('mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
            'deskripsi'  => 'nullable'
        ], [
            'nama_mapel.required' => 'Nama mapel wajib diisi',
        ]);

        MapelModel::create([
            'nama_mapel' => $request->nama_mapel,
            'deskripsi'  => $request->deskripsi,
        ]);

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Data mapel berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $mapel = MapelModel::findOrFail($id);

        return view('mapel.show', compact('mapel'));
    }

    public function edit(string $id)
    {
        $mapel = MapelModel::findOrFail($id);

        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request, string $id)
    {
        $mapel = MapelModel::findOrFail($id);

        $request->validate([
            'nama_mapel' => 'required',
            'deskripsi'  => 'nullable'
        ], [
            'nama_mapel.required' => 'Nama mapel wajib diisi',
        ]);

        $mapel->update([
            'nama_mapel' => $request->nama_mapel,
            'deskripsi'  => $request->deskripsi,
        ]);

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Data mapel berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $mapel = MapelModel::findOrFail($id);

        $mapel->delete();

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Data mapel berhasil dihapus');
    }
}