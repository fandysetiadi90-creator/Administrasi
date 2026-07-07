<?php

namespace App\Http\Controllers;

use App\Models\RuleAdministrasi;
use Illuminate\Http\Request;

class RuleAdministrasiController extends Controller
{
    public function index()
    {
        $komponen = [
            'CP',
            'ATP',
            'PROTA',
            'PROSEM',
            'MODUL AJAR',
            'JURNAL MENGAJAR'
        ];

        foreach ($komponen as $item) {

            RuleAdministrasi::firstOrCreate(
                ['komponen' => $item],
                ['status' => 'Wajib']
            );
        }

        $rules = RuleAdministrasi::orderBy('id_rule')->get();

        return view(
            'rule-administrasi.index',
            compact('rules')
        );
    }

    public function update(Request $request)
    {
        RuleAdministrasi::query()->update([
            'status' => 'Tidak Wajib'
        ]);

        if ($request->has('status')) {

            RuleAdministrasi::whereIn(
                'id_rule',
                $request->status
            )->update([
                'status' => 'Wajib'
            ]);
        }

        return redirect()
            ->route('rule-administrasi.index')
            ->with(
                'success',
                'Rule administrasi berhasil diperbarui.'
            );
    }
}