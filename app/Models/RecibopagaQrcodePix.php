<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use Illuminate\Database\Eloquent\Builder;

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
        'k176_instituicao_financeira',
        'k176_codigo_conciliacao_recebedor'
    ];

    public function scopeWhereNumpreNumpar(Builder $query, int $numpre, int $numpar = null): void
    {
        if ($numpar === null) {
            $query->where('k176_numnov', $numpre);
        }

        $query->where('k176_numpre', $numpre)->where('k176_numpar', $numpar);
    }

    public function scopeOfCodigoConciliacaoRecebedor(Builder $query, string $code): void
    {
        $query->where('k176_codigo_conciliacao_recebedor', $code);
    }
}