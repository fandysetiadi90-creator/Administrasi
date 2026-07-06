<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalHarianModel extends Model
{
    protected $table = 'jurnal_harian';
    protected $primaryKey = 'id_jurnal_harian';

    protected $fillable = [
        'id_administrasi',
        'id_cp_detail',
        'id_atp_detail',
        'minggu',
        'tanggal',
        'penilaian',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function administrasi()
    {
        return $this->belongsTo(
            AdministrasiModel::class,
            'id_administrasi',
            'id_administrasi'
        );
    }

    public function cpDetail()
    {
        return $this->belongsTo(CpDetailModel::class, 'id_cp_detail', 'id_cp_detail');
    }

    public function atpDetail()
    {
        return $this->belongsTo(
            AtpDetailModel::class,
            'id_atp_detail',
            'id_atp_detail'
        );
    }
}
