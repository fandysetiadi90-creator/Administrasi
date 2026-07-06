<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkunModel extends Model
{
    protected $table = 'akun';
    protected $primaryKey = 'id_akun';

    protected $fillable = [
        'id_pengguna',
        'password',
    ];

    public function pengguna()
    {
        return $this->belongsTo(PenggunaModel::class, 'id_pengguna', 'id_pengguna');
    }
}
