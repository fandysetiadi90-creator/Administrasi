<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CpModel;
use App\Models\MapelModel;
use App\Models\PeriodeModel;
use App\Models\AdministrasiModel;
use App\Models\CpDetailModel;
use App\Models\PenggunaModel;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class CpController extends Controller
{

    public function index()
    {
        $cp = CpModel::with([
            'administrasi.pengguna',
            'administrasi.kelas',
            'administrasi.mapel',
            'administrasi.periode',
            'detail.atpDetail'
        ])
        ->whereHas('administrasi', function ($query) {
            $query->where('pengguna_id', Auth::id());
        })
        ->latest()
        ->get();

        return view('cp.index', compact('cp'));
    }

    public function create()
    {
        $pengguna = Auth::user();

        $kelas = $pengguna->kelas;

        $periode = PeriodeModel::where(
            'status',
            'Aktif'
        )->first();

        $mapelSudahAda = CpModel::join(
            'administrasi',
            'cp.id_administrasi',
            '=',
            'administrasi.id_administrasi'
        )
            ->where(
                'administrasi.id_kelas',
                $kelas->id_kelas
            )
            ->where(
                'administrasi.id_periode',
                $periode->id_periode
            )
            ->pluck('administrasi.id_mapel');

        $mapel = MapelModel::whereNotIn(
            'id_mapel',
            $mapelSudahAda
        )->get();

        return view(
            'cp.create',
            compact('mapel')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_mapel' => 'required',
            'elemen' => 'required|array',
            'capaian_pembelajaran' => 'required|array',
        ]);

        $pengguna = Auth::user();

        $kelas = $pengguna->kelas;

        $periode = PeriodeModel::where(
            'status',
            'Aktif'
        )->first();

        $cek = CpModel::whereHas(
            'administrasi',
            function ($q) use (
                $request,
                $kelas,
                $periode
            ) {

                $q->where('id_mapel', $request->id_mapel)
                    ->where('id_kelas', $kelas->id_kelas)
                    ->where('id_periode', $periode->id_periode);
            }
        )->exists();

        if ($cek) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'CP untuk mata pelajaran tersebut sudah dibuat.'
                );
        }

        $administrasi = AdministrasiModel::create([
            'id_pengguna' => $pengguna->id_pengguna,
            'id_kelas' => $kelas->id_kelas,
            'id_mapel' => $request->id_mapel,
            'id_periode' => $periode->id_periode,
            'status' => 'Lengkap',
        ]);

        $cp = CpModel::create([
            'id_administrasi' => $administrasi->id_administrasi,
            'status_verifikasi' => 'Menunggu',
            'catatan_revisi' => null,
        ]);

        foreach ($request->elemen as $i => $elemen) {

            $cpDetail = $cp->detail()->create([
                'elemen' => $elemen,
                'capaian_pembelajaran' =>
                $request->capaian_pembelajaran[$i],
            ]);

            if (
                isset($request->semester[$i])
            ) {

                foreach (
                    $request->semester[$i]
                    as $j => $semester
                ) {

                    $cpDetail->atpDetail()->create([
                        'semester' => $semester,

                        'tujuan_pembelajaran' =>
                        $request->tujuan_pembelajaran[$i][$j],

                        'alur_tujuan_pembelajaran' =>
                        $request->alur_tujuan_pembelajaran[$i][$j],

                        'alokasi_waktu' =>
                        $request->alokasi_waktu[$i][$j],
                    ]);
                }
            }
        }

        return redirect()
            ->route('cp.index')
            ->with(
                'success',
                'Analisis CP berhasil ditambahkan'
            );
    }

    public function show(string $id)
    {

        $cp = CpModel::with([
            'administrasi.pengguna',
            'administrasi.kelas',
            'administrasi.mapel',
            'administrasi.periode',
            'detail.atpDetail'
        ])->findOrFail($id);

        return view('cp.show', compact('cp'));
    }

    public function edit(string $id)
    {
        $cp = CpModel::with([
            'administrasi.mapel',
            'detail.atpDetail'
        ])->findOrFail($id);

        $mapel = MapelModel::all();

        return view('cp.edit', compact('cp', 'mapel'));
    }

    public function update(Request $request, string $id)
    {
        $cp = CpModel::with([
            'detail.atpDetail',
            'administrasi'
        ])->findOrFail($id);

        $cp->administrasi->update([
            'id_mapel' => $request->id_mapel
        ]);

        $cp->update([
            'status_verifikasi' => 'Menunggu',
            'catatan_revisi' => null,
        ]);

        // hapus seluruh ATP Detail
        foreach ($cp->detail as $detail) {
            $detail->atpDetail()->delete();
        }

        // hapus CP Detail
        $cp->detail()->delete();

        // simpan ulang
        foreach ($request->elemen as $i => $elemen) {

            $cpDetail = $cp->detail()->create([
                'elemen' => $elemen,
                'capaian_pembelajaran' =>
                $request->capaian_pembelajaran[$i],
            ]);

            if (isset($request->semester[$i])) {

                foreach ($request->semester[$i] as $j => $semester) {

                    $cpDetail->atpDetail()->create([
                        'semester' => $semester,

                        'tujuan_pembelajaran' =>
                        $request->tujuan_pembelajaran[$i][$j],

                        'alur_tujuan_pembelajaran' =>
                        $request->alur_tujuan_pembelajaran[$i][$j],

                        'alokasi_waktu' =>
                        $request->alokasi_waktu[$i][$j],
                    ]);
                }
            }
        }

        return redirect()
            ->route('cp.show', $cp->id_cp)
            ->with(
                'success',
                'Analisis CP berhasil diperbarui'
            );
    }

    public function destroy(string $id)
    {
        $cp = CpModel::with(
            'detail.atpDetail'
        )->findOrFail($id);

        foreach ($cp->detail as $detail) {

            $detail->atpDetail()->delete();
        }

        $cp->detail()->delete();

        $cp->administrasi()->delete();

        $cp->delete();

        return redirect()
            ->route('cp.index')
            ->with(
                'success',
                'Data berhasil dihapus'
            );
    }

    public function downloadPdf($id)
    {
        $cp = CpModel::with([
            'administrasi.pengguna',
            'administrasi.mapel',
            'administrasi.kelas',
            'administrasi.periode',
            'detail.atpDetail'
        ])->findOrFail($id);

        $totalTP = 0;
        $totalJP = 0;

        foreach ($cp->detail as $detail) {
            foreach ($detail->atpDetail as $atp) {
                $totalTP++;

                $jp = (int) filter_var($atp->alokasi_waktu, FILTER_SANITIZE_NUMBER_INT);
                $totalJP += $jp;
            }
        }

        $atps = collect();

        foreach ($cp->detail as $detail) {
            foreach ($detail->atpDetail as $atp) {
                $atps->push($atp);
            }
        }

        // GROUP BY SEMESTER (FINAL FIX)
        $grouped = $atps->groupBy('semester');

        $guru = $cp->administrasi->pengguna;
        $kelas = $cp->administrasi->kelas;

        $kepalaSekolah = PenggunaModel::where('jabatan', 'Kepala Sekolah')->first();

        $bulan = Carbon::now()
            ->locale('id')
            ->translatedFormat('F Y');

        return Pdf::loadView('cp.pdf', [
            'cp' => $cp,
            'guru' => $guru,
            'kelas' => $kelas,
            'totalTP' => $totalTP,
            'totalJP' => $totalJP,
            'grouped' => $grouped,
            'kepalaSekolah' => $kepalaSekolah,
            'bulan' => $bulan,
        ])
        ->setPaper('a4', 'portrait')
        ->download('Analisis_CP_' . $cp->id_cp . '.pdf');
    }

    public function getCpDetail($id_administrasi)
    {
        $data = CpDetailModel::where('id_administrasi', $id_administrasi)->get();

        return response()->json($data);
    }
}
