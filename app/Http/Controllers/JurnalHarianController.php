<?php

namespace App\Http\Controllers;

use App\Models\AdministrasiModel;
use App\Models\AtpDetailModel;
use App\Models\CpDetailModel;
use App\Models\JurnalHarianModel;
use App\Models\PenggunaModel;
use App\Models\PeriodeModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurnalHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $jurnalHarian = JurnalHarianModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'atpDetail.cpDetail'
        ])
        ->whereHas('administrasi', function ($q) use ($user) {
            $q->where('id_pengguna', $user->id_pengguna);
        })
        ->orderBy('tanggal', 'desc')
        ->get();
        $periode = PeriodeModel::all();

        return view(
            'jurnal_harian.index',
            compact('jurnalHarian', 'periode')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $administrasi = AdministrasiModel::with('mapel')
            ->where('id_pengguna', Auth::id())
            ->get();

        return view('jurnal_harian.create', compact('administrasi'));
    }

    public function getCp($id_administrasi)
    {
        $data = CpDetailModel::whereHas('cp', function ($q) use ($id_administrasi) {
            $q->where('id_administrasi', $id_administrasi);
        })->get();

        return response()->json($data);
    }

    public function getAtp($id_cp_detail)
    {
        try {

            $data = AtpDetailModel::where('id_cp_detail', $id_cp_detail)
                ->get();

            return response()->json($data);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_administrasi' => 'required',
            'id_cp_detail' => 'required',
            'id_atp_detail' => 'required',
            'minggu' => 'required|integer',
            'penilaian' => 'nullable',
            'tanggal' => 'required|date',
        ]);

        JurnalHarianModel::create([
            'id_administrasi' => $request->id_administrasi,
            'id_cp_detail' => $request->id_cp_detail,
            'id_atp_detail' => $request->id_atp_detail,
            'minggu' => $request->minggu,
            'penilaian' => $request->penilaian,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('jurnal-harian.index')
            ->with('success', 'Jurnal berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jurnal = JurnalHarianModel::findOrFail($id);

        $administrasi = AdministrasiModel::with(['mapel', 'kelas'])->get();

        return view('jurnal_harian.edit', compact(
            'jurnal',
            'administrasi'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_administrasi' => 'required|exists:administrasi,id_administrasi',
            'id_cp_detail'    => 'required|exists:cp_detail,id_cp_detail',
            'id_atp_detail'   => 'required|exists:atp_detail,id_atp_detail',
            'minggu'          => 'required|integer|min:1',
            'penilaian'       => 'nullable|string',
            'tanggal'         => 'required|date',
        ]);

        $jurnal = JurnalHarianModel::findOrFail($id);

        $jurnal->update([
            'id_administrasi' => $request->id_administrasi,
            'id_cp_detail'    => $request->id_cp_detail,
            'id_atp_detail'   => $request->id_atp_detail,
            'minggu'          => $request->minggu,
            'penilaian'       => $request->penilaian,
            'tanggal'         => $request->tanggal,
        ]);

        return redirect()
            ->route('jurnal-harian.index')
            ->with('success', 'Jurnal berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jurnal = JurnalHarianModel::findOrFail($id);

        $jurnal->delete();

        return redirect()
            ->route('jurnal-harian.index')
            ->with('success', 'Jurnal Harian berhasil dihapus');
    }

    public function pdf(Request $request)
    {
        $request->validate([
            'id_periode' => 'required|exists:periode,id_periode',
        ]);

        $jurnal = JurnalHarianModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'administrasi.pengguna',
            'administrasi.periode',
            'cpDetail',
            'atpDetail'
        ])
        ->whereHas('administrasi', function ($q) use ($request) {
            $q->where('id_periode', $request->id_periode);
        })
        ->get();

        $guru = $jurnal->first()?->administrasi?->pengguna;
        $kelas = $jurnal->first()?->administrasi?->kelas;

        $kepalaSekolah = PenggunaModel::where('jabatan', 'Kepala Sekolah')->first();

        $bulan = Carbon::now()
            ->locale('id')
            ->translatedFormat('F Y');

        return Pdf::loadView('jurnal_harian.pdf', [
            'jurnal' => $jurnal,
            'guru' => $guru,
            'kelas' => $kelas,
            'kepalaSekolah' => $kepalaSekolah,
            'bulan' => $bulan,
        ])
        ->setPaper('a4', 'portrait')
        ->download('JURNAL_HARIAN_' . date('Y') . '.pdf');
    }
}
