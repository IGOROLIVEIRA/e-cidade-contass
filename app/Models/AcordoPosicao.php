<?php

namespace App\Models;

class AcordoPosicao extends LegacyModel
{
    /**
     * @var string
     */
    protected $table = 'acordoposicao';

    /**
     * @var string
     */
    protected $primaryKey = 'ac26_sequencial';

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

    public function itens()
    {
        return $this->hasMany('App\Models\AcordoItem', 'ac20_acordoposicao', 'ac26_sequencial');
    }

    public function acordo()
    {
        return $this->belongsTo(Acordo::class, 'ac26_acordo', 'ac16_sequencial');
    }

    public function posicaoAditamento()
    {
        return $this->hasOne(AcordoPosicaoAditamento::class, 'ac35_acordoposicao', 'ac26_sequencial');
    }
}
