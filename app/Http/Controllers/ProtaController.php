<?php

namespace App\Http\Controllers;

use App\Models\AdministrasiModel;
use App\Models\AtpDetailModel;
use App\Models\PenggunaModel;
use App\Models\ProtaDetailModel;
use App\Models\ProtaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProtaController extends Controller
{

    public function index()
    {
        $prota = ProtaModel::with([
            'administrasi'
        ])
        ->whereHas('administrasi', function ($query) {
            $query->where('id_pengguna', Auth::id());
        })
            ->latest()
            ->get();

        return view(
            'prota.index',
            compact('prota')
        );
    }

    public function create()
    {
        $administrasi = AdministrasiModel::with(['mapel', 'kelas', 'periode'])
            ->where('id_pengguna', Auth::id())
            ->whereDoesntHave('prota')
            ->latest()
            ->get();

        return view('prota.create', compact('administrasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_administrasi' => 'required|exists:administrasi,id_administrasi',
            'alokasi_per_minggu' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            /*
        |------------------------------------------------------------
        | Ambil seluruh ATP Detail berdasarkan Administrasi
        | Administrasi -> CP -> CP Detail -> ATP Detail
        |------------------------------------------------------------
        */
            $atpDetails = AtpDetailModel::whereHas(
                'cpDetail.cp',
                function ($q) use ($request) {
                    $q->where(
                        'id_administrasi',
                        $request->id_administrasi
                    );
                }
            )
                ->orderBy('id_atp_detail')
                ->get();

            if ($atpDetails->isEmpty()) {
                return back()->with(
                    'error',
                    'Data ATP Detail tidak ditemukan.'
                );
            }

            /*
        |------------------------------------------------------------
        | Hitung Total JP
        |------------------------------------------------------------
        */
            $totalJp = $atpDetails->sum(function ($item) use ($request) {
                return (int) preg_replace(
                    '/[^0-9]/',
                    '',
                    $request->alokasi_waktu[$item->id_atp_detail]
                );
            });

            /*
        |------------------------------------------------------------
        | Simpan Header Prota
        |------------------------------------------------------------
        */
            $prota = ProtaModel::create([
                'id_administrasi'     => $request->id_administrasi,
                'total_jp'            => $totalJp,
                'alokasi_per_minggu'  => $request->alokasi_per_minggu,
                'status_verifikasi'   => 'Menunggu',
            ]);

            /*
        |------------------------------------------------------------
        | Simpan Detail Prota (Snapshot)
        |------------------------------------------------------------
        */
            foreach ($atpDetails as $item) {

                ProtaDetailModel::create([
                    'id_prota' => $prota->id_prota,

                    'id_atp_detail' => $item->id_atp_detail,

                    'alur_tujuan_pembelajaran'
                    => $item->alur_tujuan_pembelajaran,

                    'semester'
                    => $item->semester,

                    'alokasi_waktu'
                    => $request->alokasi_waktu[$item->id_atp_detail]
                        ?? $item->alokasi_waktu,
                ]);
            }

            DB::commit();

            return redirect()
                ->route(
                    'prota.show',
                    $prota->id_prota
                )
                ->with(
                    'success',
                    'Prota berhasil dibuat.'
                );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    public function show(string $id)
    {
        $prota = ProtaModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'administrasi.periode',
            'protaDetail.atpDetail'
        ])->findOrFail($id);

        return view('prota.show', compact('prota'));
    }

    public function edit($id)
    {
        $prota = ProtaModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'administrasi.periode',
            'protaDetail.atpDetail'
        ])->findOrFail($id);

        return view('prota.edit', compact('prota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'alokasi_per_minggu' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            $prota = ProtaModel::with('protaDetail')
                ->findOrFail($id);

            $prota->update([
                'status_verifikasi' => 'Menunggu',
                'alokasi_per_minggu' => $request->alokasi_per_minggu,
            ]);
            
            

            /*
        |-------------------------------------------------
        | Update Detail
        |-------------------------------------------------
        */
            foreach ($prota->protaDetail as $detail) {

                if (isset($request->alokasi_waktu[$detail->id_prota_detail])) {

                    $detail->update([
                        'alokasi_waktu' =>
                        $request->alokasi_waktu[$detail->id_prota_detail]
                    ]);
                }
            }

            /*
        |-------------------------------------------------
        | Hitung ulang total JP
        |-------------------------------------------------
        */
            $totalJp = ProtaDetailModel::where(
                'id_prota',
                $prota->id_prota
            )
                ->get()
                ->sum(function ($item) {

                    return (int) preg_replace(
                        '/[^0-9]/',
                        '',
                        $item->alokasi_waktu
                    );
                });

            /*
        |-------------------------------------------------
        | Update total_jp
        |-------------------------------------------------
        */
            $prota->update([
                'total_jp' => $totalJp,
            ]);

            DB::commit();

            return redirect()
                ->route(
                    'prota.show',
                    $prota->id_prota
                )
                ->with(
                    'success',
                    'Prota berhasil diperbarui.'
                );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    public function destroy($id)
    {
        $prota = ProtaModel::findOrFail($id);

        $prota->delete();

        return redirect()
            ->route('prota.index')
            ->with(
                'success',
                'Data Prota berhasil dihapus.'
            );
    }

    public function getAtpDetail($idAdministrasi)
    {
        $atpDetail = AtpDetailModel::whereHas(
            'cpDetail.cp',
            function ($q) use ($idAdministrasi) {
                $q->where(
                    'id_administrasi',
                    $idAdministrasi
                );
            }
        )->get();

        return response()->json($atpDetail);
    }

    public function downloadPdf($id)
    {
        $prota = ProtaModel::with([
            'administrasi.pengguna',
            'administrasi.mapel',
            'administrasi.kelas',
            'administrasi.periode',
            'protaDetail.atpDetail'
        ])->findOrFail($id);
        $guru = $prota->administrasi->pengguna;
        $kelas = $prota->administrasi->kelas;

        $kepalaSekolah = PenggunaModel::where('jabatan', 'Kepala Sekolah')->first();

        $bulan = Carbon::now()
            ->locale('id')
            ->translatedFormat('F Y');

        return Pdf::loadView('prota.pdf', [
            'prota' => $prota,
            'guru' => $guru, 
            'kelas' => $kelas,
            'kepalaSekolah' => $kepalaSekolah, 
            'bulan' => $bulan,

        ])
            ->setPaper('a4', 'portrait')
            ->download('PROTA_' . $prota->id_prota . '.pdf');
    }
}
