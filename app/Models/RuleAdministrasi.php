<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleAdministrasi extends Model
{
    protected $table = 'rule_administrasi';

    protected $primaryKey = 'id_rule';

    protected $fillable = [
        'komponen',
        'status'
    ];
}
