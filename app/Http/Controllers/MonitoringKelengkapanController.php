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

class MonitoringKelengkapanController extends Controller
{
   public function index()
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

            // F1 = CP
            $fakta['CP'] = CpModel::where(
                'id_administrasi',
                $adm->id_administrasi
            )->exists();

            // F2 = ATP
            $fakta['ATP'] = AtpDetailModel::whereHas(
                'cpDetail.cp',
                function ($q) use ($adm) {

                    $q->where(
                        'id_administrasi',
                        $adm->id_administrasi
                    );
                }
            )->exists();

            // F3 = PROTA
            $fakta['PROTA'] = ProtaModel::where(
                'id_administrasi',
                $adm->id_administrasi
            )->exists();

            // F4 = PROSEM
            $fakta['PROSEM'] = ProsemModel::whereHas(
                'prota',
                function ($q) use ($adm) {

                    $q->where(
                        'id_administrasi',
                        $adm->id_administrasi
                    );
                }
            )->exists();

            // F5 = MODUL AJAR
            $fakta['MODUL AJAR'] = ModulAjarModel::where(
                'id_administrasi',
                $adm->id_administrasi
            )->exists();

            // F6 = JURNAL HARIAN
            $fakta['JURNAL HARIAN'] = JurnalHarianModel::where(
                'id_administrasi',
                $adm->id_administrasi
            )->exists();

          

            $belumLengkap = [];

            foreach ($rules as $rule) {

                if (
                    $rule->status == 'Wajib'
                    &&
                    (
                        !isset($fakta[$rule->komponen])
                        ||
                        $fakta[$rule->komponen] == false
                    )
                ) {

                    $belumLengkap[] =
                        $rule->komponen;
                }
            }

            

            if (count($belumLengkap) == 0) {

                $status = 'Lengkap';

            } else {

                $status = 'Tidak Lengkap';
            }

            $hasil[] = [

                'administrasi' => $adm,

                'status' => $status,

                'belum_lengkap' => $belumLengkap,

                'jumlah_wajib' => $rules->count(),

                'jumlah_terpenuhi' =>
                    $rules->count() - count($belumLengkap),

                'persentase' =>
                    $rules->count() > 0
                    ? round(
                        (
                            ($rules->count() - count($belumLengkap))
                            /
                            $rules->count()
                        ) * 100,
                        2
                    )
                    : 0
            ];
        }

        return view(
            'monitoring-kelengkapan.index',
            compact('hasil')
        );
    }
}