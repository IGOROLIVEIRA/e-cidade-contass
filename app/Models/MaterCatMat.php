<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use Illuminate\Database\Query\Expression;

class MaterCatMat extends LegacyModel
{
    use LegacyAccount;

    public $timestamps = false;

    protected $table = 'farmacia.far_matercatmat';

    protected $primaryKey = 'faxx_i_codigo';

    protected $fillable = [
        'faxx_i_codigo',
        'faxx_i_catmat',
        'faxx_i_desc',
        'faxx_i_ativo',
        'faxx_i_susten',
    ];
}
