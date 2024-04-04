<?php

namespace App\Models;

class PcOrcamVal extends LegacyModel
{
    /**
     * @var string
     */
    protected $table = 'pcorcamval';

    /**
     * @var string
     */
    protected $primaryKey = ['pc23_orcamforne', 'pc23_orcamitem'];

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
        'pc23_orcamforne',
        'pc23_orcamitem',
        'pc23_valor',
        'pc23_quant',
        'pc23_obs',
        'pc23_vlrun',
        'pc23_validmin',
        'pc23_percentualdesconto',
        'pc23_perctaxadesctabela'
    ];
}
