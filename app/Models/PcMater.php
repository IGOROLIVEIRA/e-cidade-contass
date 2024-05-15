<?php

namespace App\Models;

class PcMater extends LegacyModel
{
    /**
     * @var string
     */
    protected $table = 'pcmater';

    /**
     * @var string
     */
    protected $primaryKey = ' pc01_codmater';

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


    public function acordoItem()
    {
        return $this->hasMany(AcordoItem::class, 'ac20_pcmater', 'pc01_codmater');
    }
}
