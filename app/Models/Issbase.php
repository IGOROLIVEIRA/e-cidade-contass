<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class Issbase extends LegacyModel
{
    use LegacyAccount;

    public $timestamps = false;

    protected $table = 'issqn.issbase';

    protected $primaryKey = 'q02_inscr';

    protected $fillable = [
        'q02_inscr',
        'q02_numcgm',
        'q02_memo',
        'q02_tiplic',
        'q02_regjuc',
        'q02_inscmu',
        'q02_obs',
        'q02_dtcada',
        'q02_dtinic',
        'q02_dtbaix',
        'q02_capit',
        'q02_cep',
        'q02_dtjunta',
        'q02_ultalt',
        'q02_dtalt',
    ];
}
