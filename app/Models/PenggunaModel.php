<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\AkunModel;

class PenggunaModel extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'email',
        'nama',
        'nomor_induk',
        'jabatan',
        'poto',
    ];

    public function akun()
    {
        return $this->hasOne(AkunModel::class, 'id_pengguna', 'id_pengguna');
    }

    public function kelas()
    {
        return $this->hasOne(KelasModel::class, 'id_pengguna', 'id_pengguna');
    }
}
