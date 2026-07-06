<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProtaDetailModel extends Model
{
    protected $table = 'prota_detail';

    protected $primaryKey = 'id_prota_detail';

    protected $fillable = [
        'id_prota',
        'id_atp_detail',
        'alur_tujuan_pembelajaran',
        'semester',
        'alokasi_waktu',
    ];

    public function prota()
    {
        return $this->belongsTo(
            ProtaModel::class,
            'id_prota',
            'id_prota'
        );
    }

    public function atpDetail()
    {
        return $this->belongsTo(
            AtpDetailModel::class,
            'id_atp_detail',
            'id_atp_detail'
        );
    }

    public function prosemDetail()
    {
        return $this->hasMany(
            ProsemDetailModel::class,
            'id_prota_detail',
            'id_prota_detail'
        );
    }
}
