<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsemKegiatanModel extends Model
{
    protected $table = 'prosem_kegiatan';

    protected $primaryKey = 'id_kegiatan';

    protected $fillable = [
        'id_prosem',
        'nama_kegiatan',
        'bulan',
        'minggu_ke',
        'warna'
    ];

    public function prosem()
    {
        return $this->belongsTo(
            ProsemModel::class,
            'id_prosem',
            'id_prosem'
        );
    }
}