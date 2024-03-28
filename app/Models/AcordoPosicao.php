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
     * @var array
     */
    protected $fillable = [
        'ac26_sequencial',
        'ac26_acordo',
        'ac26_acordoposicaotipo',
        'ac26_numero',
        'ac26_situacao',
        'ac26_data',
        'ac26_emergencial',
        'ac26_observacao',
        'ac26_numeroaditamento',
        'ac26_numeroapostilamento',
        'ac26_vigenciaalterada',
        'ac26_indicereajuste',
        'ac26_percentualreajuste',
        'ac26_descricaoindice'
    ];

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

    public function vigencia()
    {
        return $this->hasOne(AcordoVigencia::class, 'ac18_acordoposicao', 'ac26_sequencial');
    }

}
