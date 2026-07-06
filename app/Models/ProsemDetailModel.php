<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsemDetailModel extends Model   
{
    protected $table = 'prosem_detail';

    protected $primaryKey = 'id_prosem_detail';

    protected $fillable = [
        'id_prosem',
        'id_prota_detail',
        'alokasi_waktu',
        'jp',
        'bulan',
        'minggu_ke',
        'tanggal',
    ];

    public function prosem()
    {
        return $this->belongsTo(
            ProsemModel::class,
            'id_prosem',
            'id_prosem'
        );
    }

    public function protaDetail()
    {
        return $this->belongsTo(
            ProtaDetailModel::class,
            'id_prota_detail',
            'id_prota_detail'
        );
    }
}