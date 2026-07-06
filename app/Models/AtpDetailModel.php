<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtpDetailModel extends Model
{
    protected $table = 'atp_detail';

    protected $primaryKey = 'id_atp_detail';

    protected $fillable = [
        'id_cp_detail',
        'semester',
        'alur_tujuan_pembelajaran',
        'alokasi_waktu',
        'tujuan_pembelajaran',
    ];

    public function cpDetail()
    {
        return $this->belongsTo(
            CpDetailModel::class,
            'id_cp_detail',
            'id_cp_detail'
        );
    }

    public function modulAjar()
    {
        return $this->belongsToMany(
            ModulAjarModel::class,
            'modul_ajar_atp',
            'id_atp_detail',
            'id_modul_ajar'
        );
    }
}
