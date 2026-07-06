<?php

namespace App\Http\Controllers;

use App\Models\AdministrasiModel;
use App\Models\AtpDetailModel;
use App\Models\CpDetailModel;
use App\Models\ModulAjarModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ModulAjarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengguna = Auth::user();

        $modulAjar = ModulAjarModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'cpDetail',
            'atpDetail'
        ])
            ->whereHas('administrasi', function ($q) use ($pengguna) {
                $q->where(
                    'id_pengguna',
                    $pengguna->id_pengguna
                );
            })
            ->latest()
            ->get();
        return view(
            'modul_ajar.index',
            compact('modulAjar')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengguna = Auth::user();

        $administrasi = AdministrasiModel::with([
            'mapel',
            'kelas'
        ])
        ->where(
            'id_pengguna',
            $pengguna->id_pengguna
        )
        ->get();

        return view(
            'modul_ajar.create',
            compact('administrasi')
        );
    }

    public function getCpDetail($idAdministrasi)
    {
        $cpDetail = CpDetailModel::whereHas(
            'cp',
            function ($q) use ($idAdministrasi) {

                $q->where(
                    'id_administrasi',
                    $idAdministrasi
                );
            }
        )->get();

        return response()->json($cpDetail);
    }


    public function getTujuanPembelajaran(
        $idCpDetail,
        $semester
    ) {

        $atp = AtpDetailModel::where(
            'id_cp_detail',
            $idCpDetail
        )
        ->where(
            'semester',
            $semester
        )
        ->get();

        return response()->json($atp);
    }
    
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {

            $file = $request->file('upload');

            $filename = time().'_'.$file->getClientOriginalName();

            $path = $file->storeAs(
                'modul-ajar',
                $filename,
                'public'
            );

            $url = asset('storage/'.$path);

            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'Upload gagal'], 400);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'id_administrasi' => 'required',

            'id_cp_detail' => 'required',

            'id_atp_detail' => 'required|array|min:1',

            'judul_modul' => 'required',

            'identifikasi' => 'nullable',

            'desain_pembelajaran' => 'nullable',

            'pengalaman_belajar' => 'nullable',

            'asesmen' => 'nullable',

        ]);

        DB::beginTransaction();

        try {

            $modul = ModulAjarModel::create([

                'id_administrasi'
                => $request->id_administrasi,

                'id_cp_detail'
                => $request->id_cp_detail,

                'judul_modul'
                => $request->judul_modul,

                'identifikasi'
                => $request->identifikasi,

                'desain_pembelajaran'
                => $request->desain_pembelajaran,

                'pengalaman_belajar'
                => $request->pengalaman_belajar,

                'asesmen'
                => $request->asesmen,

                'status_verifikasi'
                => 'Menunggu',

            ]);

            $modul->atpDetail()->sync(
                $request->id_atp_detail
            );

            DB::commit();

            return redirect()
                ->route('modul-ajar.index')
                ->with(
                    'success',
                    'Modul Ajar berhasil dibuat'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $modul = ModulAjarModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'cpDetail',
            'atpDetail'
        ])->findOrFail($id);

        return view('modul_ajar.show', compact('modul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengguna = Auth::user();

        $modul = ModulAjarModel::with([
            'atpDetail',
            'cpDetail',
            'administrasi.mapel',
            'administrasi.kelas'
        ])->findOrFail($id);

        $administrasi = AdministrasiModel::with([
            'mapel',
            'kelas'
        ])
        ->where('id_pengguna', $pengguna->id_pengguna)
        ->get();

        $cpDetail = CpDetailModel::whereHas('cp', function ($q) use ($modul) {
            $q->where('id_administrasi', $modul->id_administrasi);
        })->get();

        $tpList = AtpDetailModel::where('id_cp_detail', $modul->id_cp_detail)
            ->where('semester', $modul->semester ?? 1)
            ->get();

        return view('modul_ajar.edit', compact(
            'modul',
            'administrasi',
            'cpDetail',
            'tpList'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_administrasi' => 'required',
            'id_cp_detail' => 'required',
            'id_atp_detail' => 'required|array|min:1',
            'judul_modul' => 'required',
            'identifikasi' => 'nullable',
            'desain_pembelajaran' => 'nullable',
            'pengalaman_belajar' => 'nullable',
            'asesmen' => 'nullable',
        ]);

        DB::beginTransaction();

        try {

            $modul = ModulAjarModel::findOrFail($id);
            $modul->update([
                'id_modul_ajar' => $request->id_modul_ajar,
                'status_verifikasi' => 'Menunggu',
            ]);

            $modul->update([
                'id_administrasi' => $request->id_administrasi,
                'id_cp_detail' => $request->id_cp_detail,
                'judul_modul' => $request->judul_modul,
                'identifikasi' => $request->identifikasi,
                'desain_pembelajaran' => $request->desain_pembelajaran,
                'pengalaman_belajar' => $request->pengalaman_belajar,
                'asesmen' => $request->asesmen,
            ]);

            $modul->atpDetail()->sync($request->id_atp_detail);

            DB::commit();

            return redirect()
                ->route('modul-ajar.index')
                ->with('success', 'Modul Ajar berhasil diupdate');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $modul = ModulAjarModel::findOrFail($id);

            $modul->atpDetail()->detach();

            $modul->delete();

            return redirect()
                ->route('modul-ajar.index')
                ->with('success', 'Modul Ajar berhasil dihapus.');

        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }


    public function downloadPdf($id)
    {
        $modul = ModulAjarModel::with([
            'administrasi.mapel',
            'administrasi.kelas',
            'administrasi.pengguna',
            'cpDetail',
            'atpDetail'
        ])->findOrFail($id);

        // Bersihkan HTML CKEditor
        foreach ([
            'identifikasi',
            'desain_pembelajaran',
            'pengalaman_belajar',
            'asesmen'
        ] as $field) {

            if (!$modul->$field) {
                continue;
            }

            $html = $modul->$field;

            // figure image -> div
            $html = str_replace('<figure class="image">', '<div>', $html);
            $html = str_replace('<figure class="table">', '<div>', $html);
            $html = str_replace('</figure>', '</div>', $html);

            // ubah url gambar menjadi path lokal
            $html = preg_replace_callback('/<img[^>]+src="([^"]+)"/i', function ($m) {

                $src = $m[1];

                if (strpos($src, '/storage/') !== false) {

                    $path = public_path(parse_url($src, PHP_URL_PATH));

                    return str_replace($src, $path, $m[0]);
                }

                return $m[0];

            }, $html);

            $modul->$field = $html;
        }

        $pdf = Pdf::loadView('modul_ajar.pdf', compact('modul'));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Modul_Ajar_'.$modul->judul_modul.'.pdf');
    }
}
