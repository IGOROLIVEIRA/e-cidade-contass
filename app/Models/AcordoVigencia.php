<?php

namespace App\Models;

class AcordoVigencia extends LegacyModel
{
    /**
     *
     * @var string
     */
    protected string $sequenceName = 'acordovigencia_ac18_sequencial_seq';

    /**
     * @var string
     */
    protected $table = 'acordovigencia';

    /**
     * @var string
     */
    protected $primaryKey = 'ac18_sequencial';

    /**
     * @var array
     */
    protected $fillable = [
        'ac18_sequencial',
        'ac18_datainicio',
        'ac18_datafim',
        'ac18_ativo',
        'ac18_acordoposicao'
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
        return $this->belongsTo(AcordoPosicao::class,'ac18_acordoposicao', 'ac26_sequencial');
    }
}
