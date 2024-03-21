<?php

namespace App\Models;

class AcordoItem extends LegacyModel
{
    /**
     *
     * @var string
     */
    protected string $sequenceName = 'acordoitem_ac20_sequencial_seq';

    /**
     * @var string
     */
    protected $table = 'acordoitem';

    /**
     * @var string
     */
    protected $primaryKey = 'ac20_sequencial';

    /**
     * @var array
     */
    protected $fillable = [
        'ac20_sequencial',
        'ac20_acordoposicao',
        'ac20_pcmater',
        'ac20_quantidade',
        'ac20_valorunitario',
        'ac20_valortotal',
        'ac20_elemento',
        'ac20_ordem',
        'ac20_matunid',
        'ac20_resumo',
        'ac20_tipocontrole',
        'ac20_acordoposicaotipo',
        'ac20_servicoquantidade',
        'ac20_valoraditado',
        'ac20_quantidadeaditada ',
        'ac20_marca'
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

    public function acordoPosicao()
    {
        return $this->belongsTo('App\Models\AcordoPosicao', 'ac20_acordoposicao', 'ac26_sequencial');
    }

    public function pcMater()
    {
        return $this->belongsTo(PcMater::class, 'ac20_pcmater', 'pc01_codmater');
    }

    public function itemPeriodo()
    {
        return $this->hasOne(AcordoItemPeriodo::class,'ac41_acordoitem', 'ac20_sequencial');
    }

    public function itemExecutado()
    {
        return $this->hasOne(AcordoItemExecutado::class, 'ac29_acordoitem', 'ac20_sequencial');
    }
}
