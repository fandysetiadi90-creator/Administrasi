<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProsemModel extends Model
{

    protected $table = 'prosem';

    protected $primaryKey = 'id_prosem';

    protected $fillable = [
        'id_prota',
        'semester', 
        'status_verifikasi',
        'catatan_revisi'
    ];

    public function prota()
    {
        return $this->belongsTo(
            ProtaModel::class,
            'id_prota',
            'id_prota'
        );
    }

    public function prosemDetail()
    {
        return $this->hasMany(
            ProsemDetailModel::class,
            'id_prosem',
            'id_prosem'
        );
    }

    public function kegiatan()
    {
        return $this->hasMany(
            ProsemKegiatanModel::class,
            'id_prosem',
            'id_prosem'
        );
    }
}