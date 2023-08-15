<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class Disarq extends LegacyModel
{
    use LegacyAccount;

    protected string $sequenceName = 'disarq_codret_seq';

    /**
     * @var string
     */
    protected $table = 'caixa.disarq';

    /**
     * @var string
     */
    protected $primaryKey = 'codret';

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
        'id_usuario',
        'k15_codbco',
        'k15_codage',
        'codret',
        'arqret',
        'textoret',
        'dtretorno',
        'dtarquivo',
        'k00_conta',
        'autent',
        'instit',
        'md5'
    ];
}