<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class Disbanco extends LegacyModel
{
    use LegacyAccount;

    public string $sequenceName = 'disbanco_idret_seq';
    /**
     * @var string
     */
    protected $table = 'caixa.disbanco';

    /**
     * @var string
     */
    protected $primaryKey = 'idret';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'k00_numbco',
        'k15_codbco',
        'k15_codage',
        'codret',
        'dtarq',
        'dtpago',
        'vlrpago',
        'vlrjuros',
        'vlrmulta',
        'vlracres',
        'vlrdesco',
        'vlrtot',
        'cedente',
        'vlrcalc',
        'idret',
        'classi',
        'k00_numpre',
        'k00_numpar',
        'convenio',
        'instit',
        'dtcredito',
        'idret'
    ];
}