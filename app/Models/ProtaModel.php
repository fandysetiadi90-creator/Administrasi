<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProtaModel extends Model
{
    protected $table = 'prota';

    protected $primaryKey = 'id_prota';

    protected $fillable = [
        'id_administrasi',
        'total_jp',
        'alokasi_per_minggu',
        'status_verifikasi',
        'catatan_revisi',
    ];

    /**
     * Relasi ke Administrasi
     */
    public function administrasi()
    {
        return $this->belongsTo(
            AdministrasiModel::class,
            'id_administrasi',
            'id_administrasi'
        );
    }

    public function protaDetail()
    {
        return $this->hasMany(
            ProtaDetailModel::class,
            'id_prota',
            'id_prota'
        );
    }

    public function prosem()
    {
        return $this->hasMany(
            ProsemModel::class,
            'id_prota',
            'id_prota'
        );
    }
}
