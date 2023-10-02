<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use Illuminate\Database\Eloquent\Builder;

class Cadban extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'caixa.cadban';

    /**
     * @var string
     */
    protected $primaryKey = 'k15_codigo';

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
        'k15_codigo',
        'k15_numcgm',
        'k15_codbco',
        'k15_codage',
        'k15_contat',
        'k15_gerent',
        'k15_agenci',
        'k15_conv1',
        'k15_conv2',
        'k15_conv3',
        'k15_conv4',
        'k15_conv5',
        'k15_seq1',
        'k15_seq2',
        'k15_seq3',
        'k15_seq4',
        'k15_seq5',
        'k15_ceden1',
        'k15_ceden2',
        'k15_ceden3',
        'k15_ceden4',
        'k15_ceden5',
        'k15_posbco',
        'k15_poslan',
        'k15_pospag',
        'k15_posvlr',
        'k15_posacr',
        'k15_posdes',
        'k15_posced',
        'k15_poscon',
        'k15_seq',
        'k15_conta',
        'k15_rectxb',
        'k15_txban',
        'k15_local',
        'k15_carte',
        'k15_espec',
        'k15_aceite',
        'k15_ageced',
        'k15_posjur',
        'k15_posmul',
        'k15_taman',
        'k15_posdta',
        'k15_numbco',
        'k15_numpre',
        'k15_numpar',
        'k15_plmes',
        'k15_plano',
        'k15_pdmes',
        'k15_pdano',
        'k15_ppmes',
        'k15_ppano',
        'k15_debcta',
        'k15_instit',
        'k15_mescredito',
        'k15_diacredito',
        'k15_anocredito'
    ];

    public function scopeOfBankId(Builder $query, int $bankId): void
    {
        $query->where('k15_codbco', $bankId);
    }
}