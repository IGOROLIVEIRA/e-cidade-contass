<?php

namespace App\Models;

class PcOrcam extends LegacyModel
{
    /**
     * @var string
     */
    protected $table = 'pcorcam';

    /**
     * @var string
     */
    protected $primaryKey = 'pc20_codorc';

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
        'pc20_codorc',
        'pc20_dtate',
        'pc20_hrate',
        'pc20_obs',
        'pc20_prazoentrega',
        'pc20_validadeorcamento',
        'pc20_cotacaoprevia',
        'pc20_importado'

    ];
}
