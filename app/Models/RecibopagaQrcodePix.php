<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class RecibopagaQrcodePix extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'arrecadacao.recibopaga_qrcode_pix';

    /**
     * @var string
     */
    protected $primaryKey = 'k176_sequencial';

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
        'k176_numnov',
        'k176_numpre',
        'k176_numpar',
        'k176_dtcriacao',
        'k176_qrcode',
        'k176_hist',
        'k176_instituicao_financeira'
    ];
}