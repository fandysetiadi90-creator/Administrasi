<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrasiModel extends Model
{
    protected $table = 'administrasi';

    protected $primaryKey = 'id_administrasi';

    protected $fillable = [
        'id_pengguna',
        'id_kelas',
        'id_mapel',
        'id_periode',
        'status',   
    ];

    public function pengguna()
    {
        return $this->belongsTo(
            PenggunaModel::class,
            'id_pengguna',
            'id_pengguna'
        );
    }

    public function kelas()
    {
        return $this->belongsTo(
            KelasModel::class,
            'id_kelas',
            'id_kelas'
        );
    }

    public function mapel()
    {
        return $this->belongsTo(
            MapelModel::class,
            'id_mapel',
            'id_mapel'
        );
    }

    public function periode()
    {
        return $this->belongsTo(
            PeriodeModel::class,
            'id_periode',
            'id_periode'
        );
    }
    public function cp()
    {
        return $this->hasOne(
            CpModel::class,
            'id_administrasi',
            'id_administrasi'
        );
    }

    public function prota()
    {
        return $this->hasMany(
            ProtaModel::class,
            'id_administrasi',
            'id_administrasi'
        );
    }
}
