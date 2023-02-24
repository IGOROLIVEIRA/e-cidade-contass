<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class Numpref extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'caixa.numpref';

    /**
     * @var string
     */
    protected $primaryKey = 'k03_anousu, k03_instit';

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
        'k03_anousu',
        'k03_numpre',
        'k03_defope',
        'k03_recjur',
        'k03_numsli',
        'k03_impend',
        'k03_unipri',
        'k03_codbco',
        'k03_codage',
        'k03_recmul',
        'k03_calrec',
        'k03_msg',
        'k03_msgcarne',
        'k03_msgbanco',
        'k03_certissvar',
        'k03_diasjust',
        'k03_reccert',
        'k03_taxagrupo',
        'k03_tipocodcert',
        'k03_instit',
        'k03_reciboprot',
        'k03_regracnd',
        'k03_reciboprotretencao',
        'k03_tipocertidao',
        'k03_separajurmulparc',
        'k03_respcgm',
        'k03_respcargo',
        'k03_msgautent',
        'k03_toleranciapgtoparc',
        'k03_pgtoparcial',
        'k03_reemissaorecibo',
        'k03_numprepgtoparcial',
        'k03_agrupadorarquivotxtbaixabanco',
        'k03_receitapadraocredito',
        'k03_diasvalidadecertidao',
        'k03_diasreemissaocertidao',
        'k03_toleranciacredito',
        'k03_ativo_integracao_pix',
    ];
}