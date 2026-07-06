<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CpModel extends Model
{
    protected $table = 'cp';

    protected $primaryKey = 'id_cp';

    protected $fillable = [
        'id_administrasi',
        'status_verifikasi',
        'catatan_revisi',
    ];

    public function administrasi()
    {
        return $this->belongsTo(
            AdministrasiModel::class,
            'id_administrasi',
            'id_administrasi'
        );
    }

    public function detail()
    {
        return $this->hasMany(
            CpDetailModel::class,
            'id_cp',
            'id_cp'
        );
    }

}
