<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    protected $table = 'periode';

    protected $primaryKey = 'id_periode';

    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'status',
    ];

    public function administrasi()
    {
        return $this->hasMany(AdministrasiModel::class, 'id_periode', 'id_periode');
    }
}
