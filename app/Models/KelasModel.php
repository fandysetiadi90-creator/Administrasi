<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasModel extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $fillable = [
        'id_pengguna',
        'nama',
        'fase',
        'deskripsi',
    ];

    public function pengguna()
    {
        return $this->belongsTo(PenggunaModel::class, 'id_pengguna', 'id_pengguna');
    }

    
    public function siswa()
    {
        return $this->hasMany(SiswaModel::class, 'id_kelas', 'id_kelas');
    }
}
