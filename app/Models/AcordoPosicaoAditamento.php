<?php

namespace App\Models;

class AcordoPosicaoAditamento extends LegacyModel
{
    /**
     * @var string
     */
    protected $table = 'acordoposicaoaditamento';

    /**
     * @var string
     */
    protected $primaryKey = 'ac16_sequencial';

     /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     *  Indicates if the timestamp is active.
     *
     * @var boolean
     */
    public $timestamps = false;

    public function posicao()
    {
        return $this->belongsTo(AcordoPosicao::class,'ac35_acordoposicao', 'ac26_sequencial');
    }
}
