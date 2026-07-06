<?php

namespace App\Http\Controllers;

use App\Models\AtpModel;
use Illuminate\Http\Request;
use App\Models\CpModel;
use App\Models\ModulAjarModel;
use App\Models\ProsemModel;
use App\Models\Prota;
use App\Models\ProtaModel;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
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
            ->latest()
            ->get();

        return view(
            'monitoring.cp.index',
            compact('cp')
        );
    }

    public function show($id)
    {
        $cp = CpModel::with([
            'administrasi.pengguna',
            'administrasi.kelas',
            'administrasi.mapel',
            'administrasi.periode',
            'detail.atpDetail'
        ])
            ->findOrFail($id);

        return view(
            'monitoring.cp.show',
            compact('cp')
        );
    }

    public function revisi(Request $request, $id)
    {
        $request->validate([
            'catatan_revisi' => 'required|string',
        ], [
            'catatan_revisi.required' => 'Catatan revisi wajib diisi',
        ]);

        $cp = CpModel::findOrFail($id);

        $cp->update([
            'status_verifikasi' => 'Revisi',
            'catatan_revisi' => $request->catatan_revisi,
        ]);

        return redirect()
            ->route('monitoring.cp.show', $cp->id_cp)
            ->with(
                'success',
                'Revisi berhasil dikirim'
            );
    }

    public function approve($id)
    {
        $cp = CpModel::findOrFail($id);

        $cp->update([
            'status_verifikasi' => 'Disetujui',
            'catatan_revisi' => null,
        ]);

        return redirect()
            ->route('monitoring.cp.show', $cp->id_cp)
            ->with(
                'success',
                'CP berhasil disetujui'
            );
    }

    public function modulAjar()
    {
        $modulAjar = ModulAjarModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'administrasi.pengguna',
            'cpDetail',
            'atpDetail'
        ])
        ->latest()
        ->get();

        $menunggu = ModulAjarModel::where('status_verifikasi', 'Menunggu')->count();
        $disetujui = ModulAjarModel::where('status_verifikasi', 'Disetujui')->count();
        $revisi = ModulAjarModel::where('status_verifikasi', 'Revisi')->count();

        return view('monitoring.modul_ajar.index', compact(
            'modulAjar',
            'menunggu',
            'disetujui',
            'revisi'
        ));
    }

    public function showModulAjar($id)
    {
        $modulAjar = ModulAjarModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'administrasi.pengguna',
            'cpDetail',
            'atpDetail'
        ])->findOrFail($id);

        return view(
            'monitoring.modul_ajar.show',
            compact('modulAjar')
        );
    }

    public function approveModulAjar($id)
    {
        $modulAjar = ModulAjarModel::findOrFail($id);

        $modulAjar->update([
            'status_verifikasi' => 'Disetujui',
            'catatan_revisi' => null,
        ]);

        return redirect()
            ->route('monitoring.modul-ajar.show', $id)
            ->with('success', 'Modul Ajar berhasil disetujui');
    }

    public function revisiModulAjar(Request $request, $id)
    {
        $request->validate([
            'catatan_revisi' => 'required',
        ], [
            'catatan_revisi.required' => 'Catatan revisi wajib diisi',
        ]);

        $modulAjar = ModulAjarModel::findOrFail($id);

        $modulAjar->update([
            'status_verifikasi' => 'Revisi',
            'catatan_revisi' => $request->catatan_revisi,
        ]);

        return redirect()
            ->route('monitoring.modul_ajar.show', $id)
            ->with('success', 'Revisi Modul Ajar berhasil dikirim');
    }

    public function prota()
    {
        $prota = ProtaModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'administrasi.periode'
        ])
            ->withCount('protaDetail')
            ->latest()
            ->get();

        return view(
            'monitoring.prota.index',
            compact('prota')
        );
    }

    public function showProta($id)
    {
        $prota = ProtaModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'administrasi.periode',
            'protaDetail'
        ])->findOrFail($id);

        return view(
            'monitoring.prota.show',
            compact('prota')
        );
    }

    public function verifikasi(Request $request, $id)
    {
        $prota = ProtaModel::findOrFail($id);

        $prota->update([
            'status_verifikasi' => 'Disetujui',
            'catatan_revisi' => null,
        ]);

        return redirect()
            ->route(
                'monitoring.prota.show',
                $prota->id_prota
            )
            ->with(
                'success',
                'Prota berhasil disetujui.'
            );
    }

    public function revisiProta(Request $request, $id)
    {
        $request->validate([
            'catatan_revisi' => 'required|string'
        ]);

        $prota = ProtaModel::findOrFail($id);

        $prota->update([
            'status_verifikasi' => 'Revisi',
            'catatan_revisi' => $request->catatan_revisi,
        ]);

        return redirect()
            ->route('monitoring.prota.show', $id)
            ->with(
                'success',
                'Prota berhasil dikembalikan untuk revisi.'
            );
    }

    public function prosem()
    {
        $prosem = ProsemModel::with([
            'prota.administrasi.mapel',
            'prota.administrasi.kelas',
            'prota.administrasi.periode'
        ])
            ->withCount([
                'prosemDetail as jumlah_prota_detail' => function ($q) {
                    $q->select(DB::raw('count(distinct id_prota_detail)'));
                }
            ])
            ->latest()
            ->get();

        return view('monitoring.prosem.index', compact('prosem'));
    }

    private function normalizeBulan($bulan)
    {
        return ucfirst(strtolower(trim($bulan)));
    }

    public function showProsem($id)
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

        return view('monitoring.prosem.show', compact(
            'prosem',
            'bulanList',
            'grid',
            'colorMap',
            'groupedDetail',
            'kegiatanLegend',
        ));
    }

    public function verifikasiProsem($id)
    {
        $prosem = ProsemModel::findOrFail($id);

        $prosem->update([
            'status_verifikasi' => 'Disetujui',
            'catatan_revisi' => null,
        ]);

        return redirect()
            ->route(
                'monitoring.prosem.show',
                $id
            )
            ->with(
                'success',
                'Prosem berhasil disetujui.'
            );
    }

    public function revisiProsem(Request $request, $id)
    {
        $request->validate([
            'catatan_revisi' => 'required|string'
        ]);

        $prosem = ProsemModel::findOrFail($id);

        $prosem->update([
            'status_verifikasi' => 'Revisi',
            'catatan_revisi' => $request->catatan_revisi,
        ]);

        return redirect()
            ->route(
                'monitoring.prosem.show',
                $id
            )
            ->with(
                'success',
                'Prosem berhasil dikembalikan untuk revisi.'
            );
    }
}
