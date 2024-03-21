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
    protected $primaryKey = 'ac35_sequencial';

    /**
     * @var array
     */
    protected $fillable = [
        'ac35_sequencial',
        'ac35_valor',
        'ac35_acordoposicao',
        'ac35_dataassinaturatermoaditivo ',
        'ac35_descricaoalteracao',
        'ac35_datapublicacao',
        'ac35_veiculodivulgacao',
        'ac35_datareferencia',
        'ac35_justificativa',
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

    public function posicao()
    {
        return $this->belongsTo(AcordoPosicao::class,'ac35_acordoposicao', 'ac26_sequencial');
    }
}
