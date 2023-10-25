<?php

namespace App\Models;

class AcordoItemPeriodo extends LegacyModel
{
    /**
     * @var string
     */
    protected $table = 'acordoitemperiodo';

    /**
     * @var string
     */
    protected $primaryKey = 'ac41_sequencial';

    /**
     * @var array
     */
    protected $fillable = [
        'ac41_sequencial',
        'ac41_acordoitem',
        'ac41_datainicial',
        'ac41_datafinal',
        'ac41_acordoposicao'
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

    public function item()
    {
        return $this->belongsTo(AcordoItem::class,'ac41_acordoitem', 'ac20_sequencial');
    }
}
