<?php

namespace App\Http\Controllers;

use App\Models\PenggunaModel;
use App\Models\ProsemDetailModel;
use App\Models\ProsemKegiatanModel;
use App\Models\ProsemModel;
use App\Models\ProtaDetailModel;
use App\Models\ProtaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProsemController extends Controller
{
    public function index()
    {
        $prosem = ProsemModel::with('prota')
            ->whereHas('prota.administrasi', function ($query) {
                $query->where('id_pengguna', Auth::id());
            })
            ->latest()
            ->get();

        return view('prosem.index', compact('prosem'));
    }
    public function create()
    {
        $prota = ProtaModel::with([
                'administrasi.mapel',
                'administrasi.kelas',
                'administrasi.periode'
            ])
            ->whereHas('administrasi', function ($query) {
                $query->where('id_pengguna', Auth::id());
            })
            ->latest()
            ->get();

        $semesterTerpakai = ProsemModel::select(
            'id_prota',
            'semester'
        )->get();

        return view(
            'prosem.create',
            compact(
                'prota',
                'semesterTerpakai'
            )
        );
    }

    public function getProtaDetail($idProta, Request $request)
    {
        $prota = ProtaModel::findOrFail($idProta);

        $semester = $request->semester;

        $detailQuery = ProtaDetailModel::where('id_prota', $idProta);

        // FILTER SEMESTER
        if ($semester) {
            $detailQuery->where('semester', $semester);
        }

        $detail = $detailQuery->get();

        $rows = [];

        foreach ($detail as $item) {

            $jp = $prota->alokasi_per_minggu;

            if ($jp <= 0) continue;

            $jumlahMinggu = floor($item->alokasi_waktu / $jp);

            if ($jumlahMinggu == 0 && $item->alokasi_waktu > 0) {
                $jumlahMinggu = 1;
            }

            for ($i = 1; $i <= $jumlahMinggu; $i++) {

                $rows[] = [
                    'id_prota_detail' => $item->id_prota_detail,
                    'alur_tujuan_pembelajaran' => $item->alur_tujuan_pembelajaran,

                    'alokasi_waktu' => $item->alokasi_waktu,
                    'jp' => $jp,

                    'hasil_alokasi' => $i . ' x ' . $jp . ' JP',

                    'bulan' => null,
                    'minggu_ke' => $i,
                    'tanggal' => null,
                ];
            }
        }

        return response()->json($rows);
    }

    function getColorClass($warna)
    {
        return match ($warna) {
            'merah' => 'bg-danger',
            'kuning' => 'bg-warning',
            'hijau' => 'bg-success',
            'biru' => 'bg-primary',
            'ungu' => 'bg-purple',
            default => '',
        };
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prota' => 'required',
            'semester' => 'required',
            'detail' => 'required|array|min:1',
        ]);

        DB::beginTransaction();

        try {

            $prota = ProtaModel::findOrFail($request->id_prota);

            $exists = ProsemModel::where('id_prota', $request->id_prota)
                ->where('semester', $request->semester)
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->with('error', 'Prosem semester ini sudah dibuat.');
            }

            $prosem = ProsemModel::create([
                'id_prota' => $request->id_prota,
                'semester' => $request->semester,
            ]);

            foreach ($request->detail as $item) {

                $idProtaDetail = $item['id_prota_detail'] ?? null;

                if (
                    !$idProtaDetail ||
                    $idProtaDetail === 'null' ||
                    !is_numeric($idProtaDetail) ||
                    empty($item['bulan']) ||
                    empty($item['minggu_ke'])
                ) {
                    continue;
                }

                $protaDetail = ProtaDetailModel::with('prota')
                    ->find($idProtaDetail);

                if (!$protaDetail) {
                    continue;
                }

                $prota = $protaDetail->prota;

                ProsemDetailModel::create([
                    'id_prosem' => $prosem->id_prosem,
                    'id_prota_detail' => $protaDetail->id_prota_detail,

                    'alokasi_waktu' => $protaDetail->alokasi_waktu,
                    'jp' => $prota?->alokasi_per_minggu ?? 0,

                    'bulan' => $item['bulan'],
                    'minggu_ke' => $item['minggu_ke'],
                    'tanggal' => $item['tanggal'] ?? null,
                ]);
            }

            foreach ($request->kegiatan ?? [] as $kegiatan) {

                if (empty($kegiatan['nama_kegiatan'])) {
                    continue;
                }

                ProsemKegiatanModel::create([
                    'id_prosem' => $prosem->id_prosem,
                    'nama_kegiatan' => $kegiatan['nama_kegiatan'],
                    'bulan' => $kegiatan['bulan'] ?? null,
                    'minggu_ke' => $kegiatan['minggu_ke'] ?? null,
                    'warna' => $kegiatan['warna'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('prosem.index')
                ->with('success', 'Prosem berhasil disimpan.');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    private function normalizeBulan($bulan)
    {
        return ucfirst(strtolower(trim($bulan)));
    }

    public function show($id)
    {
        $prosem = ProsemModel::with([
            'prosemDetail',
            'kegiatan'
        ])->findOrFail($id);

        $semesterBulan = [
            1 => ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            2 => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
        ];

        $bulanTerpilih = $semesterBulan[$prosem->semester] ?? [];

        $bulanMap = [];

        foreach ($prosem->prosemDetail as $detail) {
            $bulan = $this->normalizeBulan($detail->bulan);

            if (in_array($bulan, $bulanTerpilih)) {
                $bulanMap[$bulan][] = (int) $detail->minggu_ke;
            }
        }

        foreach ($prosem->kegiatan as $kegiatan) {
            $bulan = $this->normalizeBulan($kegiatan->bulan);

            if (in_array($bulan, $bulanTerpilih)) {
                $bulanMap[$bulan][] = (int) $kegiatan->minggu_ke;
            }
        }

        $bulanList = [];

        foreach ($bulanTerpilih as $bulan) {
            if (isset($bulanMap[$bulan])) {
                $bulanList[$bulan] = max($bulanMap[$bulan]);
            } else {
                // kalau tidak ada data, tetap tampil 0 atau 1 (opsional)
                $bulanList[$bulan] = 0;
            }
        }

        $colorPalette = [
            'merah' => '#e74c3c',
            'kuning' => '#f1c40f',
            'hijau' => '#2ecc71',
            'biru'  => '#3498db',
            'ungu'  => '#9b59b6',
        ];


        $colorMap = [];

        foreach ($prosem->kegiatan as $kegiatan) {

            $bulan = $this->normalizeBulan($kegiatan->bulan);
            $minggu = (int) $kegiatan->minggu_ke;

            $warnaKey = strtolower($kegiatan->warna);
            $color = $colorPalette[$warnaKey] ?? '#cccccc';

            $colorMap[$bulan][$minggu] = $color;
        }

        $groupedDetail = $prosem->prosemDetail->groupBy('id_prota_detail');
        $grid = [];

        foreach ($groupedDetail as $idProta => $details) {
            foreach ($details as $detail) {

                $detail->hasil_alokasi = $detail->jp != 0
                    ? $detail->alokasi_waktu / $detail->jp
                    : 0;
                $bulan = $this->normalizeBulan($detail->bulan);
                $minggu = (int) $detail->minggu_ke;

                if (in_array($bulan, $bulanTerpilih)) {
                    $grid[$idProta][$bulan][$minggu] = $detail;
                }
            }
        }
        $kegiatanLegend = $prosem->kegiatan;

        return view('prosem.show', compact(
            'prosem',
            'bulanList',
            'grid',
            'colorMap',
            'groupedDetail',
            'kegiatanLegend',
        ));
    }

    public function edit($id)
    {
        $prosem = ProsemModel::with([
            'prosemDetail.protaDetail',
            'kegiatan',
            'prota.administrasi.mapel',
            'prota.administrasi.kelas',
            'prota.administrasi.periode'
        ])->findOrFail($id);

        $prota = ProtaModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'administrasi.periode'
        ])->get();

        return view('prosem.edit', compact('prosem', 'prota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_prota' => 'required',
            'detail' => 'required|array',
        ]);

        DB::beginTransaction();

        try {

            $prosem = ProsemModel::findOrFail($id);

            $prosem->update([
                'id_prota' => $request->id_prota,
                'status_verifikasi' => 'Menunggu',
            ]);

            foreach ($request->detail as $item) {

                if (!isset($item['id_prosem_detail'])) {
                    continue;
                }

                $detail = ProsemDetailModel::find($item['id_prosem_detail']);

                if (!$detail) {
                    continue;
                }

                $detail->update([
                    'bulan' => $item['bulan'],
                    'minggu_ke' => $item['minggu_ke'],
                    'tanggal' => $item['tanggal'] ?? null,
                ]);
            }

            $existingIds = [];

            foreach ($request->kegiatan ?? [] as $item) {

                if (!empty($item['id_kegiatan'])) {

                    $kegiatan = ProsemKegiatanModel::find($item['id_kegiatan']);

                    if ($kegiatan) {
                        $kegiatan->update([
                            'nama_kegiatan' => $item['nama_kegiatan'],
                            'bulan' => $item['bulan'],
                            'minggu_ke' => $item['minggu_ke'],
                            'warna' => $item['warna'] ?? null,
                        ]);

                        $existingIds[] = $kegiatan->id_kegiatan;
                    }

                    continue;
                }

                if (!empty($item['nama_kegiatan'])) {

                    $new = ProsemKegiatanModel::create([
                        'id_prosem' => $prosem->id_prosem,
                        'nama_kegiatan' => $item['nama_kegiatan'],
                        'bulan' => $item['bulan'] ?? null,
                        'minggu_ke' => $item['minggu_ke'] ?? null,
                        'warna' => $item['warna'] ?? null,
                    ]);

                    $existingIds[] = $new->id_kegiatan;
                }
            }

            ProsemKegiatanModel::where('id_prosem', $prosem->id_prosem)
                ->whereNotIn('id_kegiatan', $existingIds)
                ->delete();

            DB::commit();

            return redirect()
                ->route('prosem.index')
                ->with('success', 'Prosem berhasil diperbarui');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $prosem = ProsemModel::findOrFail($id);

        $prosem->delete();

        return redirect()
            ->route('prosem.index')
            ->with(
                'success',
                'Prosem berhasil dihapus'
            );
    }


    public function downloadPdf($id)
    {
        $prosem = ProsemModel::with([
            'prota.administrasi.pengguna',
            'prota.administrasi.mapel',
            'prota.administrasi.kelas',
            'prota.administrasi.periode',
            'prosemDetail.protaDetail',
            'kegiatan'
        ])->findOrFail($id);

        $semesterBulan = [
            1 => ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            2 => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
        ];

        $bulanTerpilih = $semesterBulan[$prosem->semester] ?? [];

        $bulanMap = [];

        foreach ($prosem->prosemDetail as $detail) {

            $bulan = $this->normalizeBulan($detail->bulan);

            if (in_array($bulan, $bulanTerpilih)) {
                $bulanMap[$bulan][] = (int) $detail->minggu_ke;
            }
        }

        foreach ($prosem->kegiatan as $kegiatan) {

            $bulan = $this->normalizeBulan($kegiatan->bulan);

            if (in_array($bulan, $bulanTerpilih)) {
                $bulanMap[$bulan][] = (int) $kegiatan->minggu_ke;
            }
        }

        $bulanList = [];

        foreach ($bulanTerpilih as $bulan) {

            $bulanList[$bulan] = isset($bulanMap[$bulan])
                ? max($bulanMap[$bulan])
                : 0;
        }

        $colorPalette = [
            'merah'  => '#e74c3c',
            'kuning' => '#f1c40f',
            'hijau'  => '#2ecc71',
            'biru'   => '#3498db',
            'ungu'   => '#9b59b6',
        ];

        $colorMap = [];

        foreach ($prosem->kegiatan as $kegiatan) {

            $bulan = $this->normalizeBulan($kegiatan->bulan);
            $minggu = (int) $kegiatan->minggu_ke;

            $warnaKey = strtolower($kegiatan->warna);

            $warna = $colorPalette[$warnaKey] ?? '#cccccc';

            // support banyak kegiatan dalam minggu yang sama
            $colorMap[$bulan][$minggu][] = [
                'warna' => $warna,
                'nama'  => $kegiatan->nama_kegiatan,
            ];
        }

        $groupedDetail = $prosem->prosemDetail
            ->groupBy('id_prota_detail');

       
        $grid = [];

        foreach ($groupedDetail as $idProta => $details) {

            foreach ($details as $detail) {

                $detail->hasil_alokasi =
                    $detail->jp != 0
                    ? $detail->alokasi_waktu / $detail->jp
                    : 0;

                $bulan = $this->normalizeBulan($detail->bulan);
                $minggu = (int) $detail->minggu_ke;

                if (in_array($bulan, $bulanTerpilih)) {

                    $grid[$idProta][$bulan][$minggu] = $detail;
                }
            }
        }

        $guru = $prosem->prota->administrasi->pengguna;
        $kelas = $prosem->prota->administrasi->kelas;

        $kepalaSekolah = PenggunaModel::where('jabatan', 'Kepala Sekolah')->first();
    
        $kegiatanLegend = $prosem->kegiatan
            ->unique('nama_kegiatan')
            ->values();
            
        $pdf = Pdf::loadView(
            'prosem.pdf',
            compact(
                'prosem',
                'bulanList',
                'grid',
                'groupedDetail',
                'colorMap',
                'guru',
                'kelas',
                'kepalaSekolah',
                'kegiatanLegend'
            )
        )
            ->setPaper('a3', 'landscape');

        return $pdf->download(
            'PROSEM_' .
                str_replace(' ', '_', $prosem->prota->administrasi->mapel->nama_mapel ?? 'Mapel')
                . '.pdf'
        );
    }
    
}
