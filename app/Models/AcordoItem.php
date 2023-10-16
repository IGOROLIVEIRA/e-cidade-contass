<?php

namespace App\Models;

class AcordoItem extends LegacyModel
{
    /**
     * @var string
     */
    protected $table = 'acordoitem';

    /**
     * @var string
     */
    protected $primaryKey = 'ac20_sequencial';

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


}
