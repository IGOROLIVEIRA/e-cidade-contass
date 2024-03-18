<?php

namespace App\Models;

class AcordoItemExecutado extends LegacyModel
{

/**
     * @var string
     */
    protected $table = 'acordoitemexecutado';

    /**
     * @var string
     */
    protected $primaryKey = 'ac29_sequencial';

    /**
     * @var array
     */
    protected $fillable = [
       'ac29_sequencial',
        'ac29_acordoitem',
        'ac29_quantidade',
        'ac29_valor',
        'ac29_tipo',
        'ac29_automatico',
        'ac29_numeroprocesso',
        'ac29_notafiscal',
        'ac29_observacao',
        'ac29_datainicial',
        'ac29_datafinal'
    ];

    public function acordoItem()
    {
        return $this->belongsTo(AcordoItem::class, 'ac29_acordoitem','ac20_sequencial');
    }
}

