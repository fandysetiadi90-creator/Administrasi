<?php

namespace App\Imports;

use App\Models\SiswaModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    protected $id_kelas;

    public function __construct($id_kelas)
    {
        $this->id_kelas = $id_kelas;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            SiswaModel::create([
                'id_kelas' => $this->id_kelas,

                'nama' => $row['nama']
                    ?? $row['Nama']
                    ?? null,

                'nis' => $row['nis']
                    ?? $row['NIS']
                    ?? null,

                'tempat_lahir' => $row['tempat_lahir']
                    ?? $row['Tempat Lahir']
                    ?? $row['tempat lahir']
                    ?? null,

                'tgl_lahir' => $row['tgl_lahir']
                    ?? $row['Tanggal Lahir']
                    ?? $row['tanggal lahir']
                    ?? null,

                'agama' => $row['agama']
                    ?? $row['Agama']
                    ?? null,

                'alamat' => $row['alamat']
                    ?? $row['Alamat']
                    ?? null,
            ]);
        }
    }
}