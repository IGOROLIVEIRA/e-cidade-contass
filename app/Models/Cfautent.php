<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use Illuminate\Database\Eloquent\Builder;

class Cfautent extends LegacyModel
{
    use LegacyAccount;

    protected string $sequenceName = 'cfautent_k11_id_seq';

    /**
     * @var string
     */
    protected $table = 'caixa.cfautent';

    /**
     * @var string
     */
    protected $primaryKey = 'k11_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    public $fillable = [
        'k11_id',
        'k11_ident1',
        'k11_ident2',
        'k11_ident3',
        'k11_ipterm',
        'k11_local',
        'k11_aut1',
        'k11_aut2',
        'k11_tipautent',
        'k11_tesoureiro',
        'k11_instit',
        'k11_tipoimp',
        'k11_tipoimpcheque',
        'k11_ipimpcheque',
        'k11_portaimpcheque',
        'k11_impassche',
        'k11_zeratrocoarrec'
    ];

}