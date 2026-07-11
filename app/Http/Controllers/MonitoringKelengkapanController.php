<?php

namespace App\Http\Controllers;

use App\Models\AdministrasiModel;
use App\Models\RuleAdministrasi;
use App\Models\CpModel;
use App\Models\AtpDetailModel;
use App\Models\ProtaModel;
use App\Models\ProsemModel;
use App\Models\ModulAjarModel;
use App\Models\JurnalHarianModel;
use Barryvdh\DomPDF\Facade\Pdf;

class MonitoringKelengkapanController extends Controller
{
   public function index()
    {
        $hasil = $this->prosesMonitoring();

        return view(
            'monitoring-kelengkapan.index',
            compact('hasil')
        );
    }

    public function downloadPdf()
    {
        $hasil = $this->prosesMonitoring();

        $pdf = Pdf::loadView(
            'monitoring-kelengkapan.pdf',
            compact('hasil')
        );

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan Monitoring Kelengkapan Administrasi.pdf');
    }

    private function prosesMonitoring()
    {
        $administrasi = AdministrasiModel::with([
            'pengguna',
            'mapel',
            'kelas',
            'periode'
        ])->get();

        $rules = RuleAdministrasi::where(
            'status',
            'Wajib'
        )->get();

        $hasil = [];

        foreach ($administrasi as $adm) {

            $fakta = [];

            $fakta['CP'] = CpModel::where(
                'id_administrasi',
                $adm->id_administrasi
            )->exists();

            $fakta['ATP'] = AtpDetailModel::whereHas(
                'cpDetail.cp',
                function ($q) use ($adm) {
                    $q->where(
                        'id_administrasi',
                        $adm->id_administrasi
                    );
                }
            )->exists();

            $fakta['PROTA'] = ProtaModel::where(
                'id_administrasi',
                $adm->id_administrasi
            )->exists();

            $fakta['PROSEM'] = ProsemModel::whereHas(
                'prota',
                function ($q) use ($adm) {
                    $q->where(
                        'id_administrasi',
                        $adm->id_administrasi
                    );
                }
            )->exists();

            $fakta['MODUL AJAR'] = ModulAjarModel::where(
                'id_administrasi',
                $adm->id_administrasi
            )->exists();

            $fakta['JURNAL HARIAN'] = JurnalHarianModel::where(
                'id_administrasi',
                $adm->id_administrasi
            )->exists();

            $belumLengkap = [];

            foreach ($rules as $rule) {

                if (
                    !isset($fakta[$rule->komponen]) ||
                    !$fakta[$rule->komponen]
                ) {

                    $belumLengkap[] = $rule->komponen;
                }
            }

            $jumlahWajib = $rules->count();

            $jumlahTerpenuhi = $jumlahWajib - count($belumLengkap);

            $persentase = $jumlahWajib > 0
                ? round(($jumlahTerpenuhi / $jumlahWajib) * 100, 2)
                : 0;

            $hasil[] = [

                'administrasi' => $adm,

                'status' => count($belumLengkap) == 0
                    ? 'Lengkap'
                    : 'Tidak Lengkap',

                'belum_lengkap' => $belumLengkap,

                'jumlah_wajib' => $jumlahWajib,

                'jumlah_terpenuhi' => $jumlahTerpenuhi,

                'persentase' => $persentase
            ];
        }

        return $hasil;
    }
}