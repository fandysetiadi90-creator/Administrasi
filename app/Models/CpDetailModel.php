<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CpDetailModel extends Model
{
    protected $table = 'cp_detail';

    protected $primaryKey = 'id_cp_detail';

    protected $fillable = [
        'id_cp',
        'elemen',
        'capaian_pembelajaran',
    ];

    public function cp()
    {
        return $this->belongsTo(
            CpModel::class,
            'id_cp',
            'id_cp'
        );
    }

    public function atpDetail()
    {
        return $this->hasMany(
            AtpDetailModel::class,
            'id_cp_detail',
            'id_cp_detail'
        );
    }
}
