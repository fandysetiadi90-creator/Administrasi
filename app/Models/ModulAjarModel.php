<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModulAjarModel extends Model
{
    protected $table = 'modul_ajar';
    protected $primaryKey = 'id_modul_ajar';

    protected $fillable = [
        'id_cp_detail',
        'id_administrasi',
        'judul_modul',
        'identifikasi',
        'desain_pembelajaran',
        'pengalaman_belajar',
        'asesmen',
        'status_verifikasi',
        'catatan_revisi',
    ];

    public function cpDetail()
    {
        return $this->belongsTo(CpDetailModel::class, 'id_cp_detail', 'id_cp_detail');
    }

    /**
     * Relasi ke Administrasi
     */
    public function administrasi()
    {
        return $this->belongsTo(AdministrasiModel::class, 'id_administrasi', 'id_administrasi');
    }

    public function atpDetail()
    {
        return $this->belongsToMany(AtpDetailModel::class,'modul_ajar_atp','id_modul_ajar','id_atp_detail');
    }
}