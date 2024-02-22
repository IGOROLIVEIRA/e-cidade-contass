<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class Socio extends LegacyModel
{
    use LegacyAccount;

    public $timestamps = false;

    protected $table = 'issqn.socios';

    protected $primaryKey = 'q95_numcgm, q95_cgmpri';

    protected $fillable = [
        'q95_cgmpri',
        'q95_numcgm',
        'q95_perc',
        'q95_tipo',
    ];
}
