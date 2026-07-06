<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapelModel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'id_mapel';

    protected $fillable = [
        'nama_mapel',
        'deskripsi'
    ];
}
