<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class IssNotaAvulsaTomadorCgmRetencao extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'issqn.issnotaavulsatomadorcgmretencao';

    /**
     * @var string
     */
    protected $primaryKey = 'numcgm';

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
        'numcgm',
        'prefeitura'
    ];
}
