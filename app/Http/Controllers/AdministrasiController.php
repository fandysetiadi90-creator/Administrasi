<?php

namespace App\Http\Controllers;

use App\Models\AdministrasiModel;
use App\Models\AtpDetailModel;
use App\Models\CpModel;
use App\Models\JurnalHarianModel;
use App\Models\ModulAjarModel;
use App\Models\ProsemModel;
use App\Models\ProtaModel;
use App\Models\RuleAdministrasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class AdministrasiController extends Controller
{
    public function index()
    {
        $idPengguna = Auth::user()->id_pengguna;

        $administrasi = AdministrasiModel::with(['pengguna','mapel','kelas','periode'])->where(
            'id_pengguna',
            $idPengguna
        )
        ->get();

        $rules = RuleAdministrasi::where('status','Wajib')->get();

        $hasil = [];

        foreach ($administrasi as $adm) {

            // Fakta
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

            // Inference Engine
            $belumLengkap = [];

            foreach ($rules as $rule) {

                if (
                    !isset($fakta[$rule->komponen]) ||
                    !$fakta[$rule->komponen]
                ) {

                    $belumLengkap[] =
                        $rule->komponen;
                }
            }

            // Rule Final

            $jumlahWajib = $rules->count();

            $jumlahTerpenuhi =
                $jumlahWajib - count($belumLengkap);

            $persentase =
                $jumlahWajib > 0
                ? round(
                    ($jumlahTerpenuhi / $jumlahWajib) * 100,
                    2
                )
                : 0;

            $hasil[] = [

                'administrasi' => $adm,

                'status' =>
                    count($belumLengkap) == 0
                    ? 'Lengkap'
                    : 'Tidak Lengkap',

                'jumlah_wajib' =>
                    $jumlahWajib,

                'jumlah_terpenuhi' =>
                    $jumlahTerpenuhi,

                'persentase' =>
                    $persentase,

                'belum_lengkap' =>
                    $belumLengkap
            ];
        }

        return view(
            'administrasi.index',
            compact('hasil')
        );
    }

    public function downloadPdf()
    {
        $idPengguna = Auth::user()->id_pengguna;

        $administrasi = AdministrasiModel::with([
            'pengguna',
            'mapel',
            'kelas',
            'periode'
        ])
        ->where('id_pengguna', $idPengguna)
        ->get();

        $rules = RuleAdministrasi::where('status', 'Wajib')->get();

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

            $persentase = $jumlahWajib
                ? round(($jumlahTerpenuhi / $jumlahWajib) * 100, 2)
                : 0;

            $hasil[] = [

                'administrasi' => $adm,

                'status' => count($belumLengkap) == 0
                    ? 'Lengkap'
                    : 'Tidak Lengkap',

                'persentase' => $persentase,

                'belum_lengkap' => $belumLengkap
            ];
        }

        $pdf = Pdf::loadView(
            'administrasi.pdf',
            compact('hasil')
        );

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('administrasi.pdf');
    }
}