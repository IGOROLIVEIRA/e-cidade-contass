<?php

namespace App\Models;

class Acordo extends LegacyModel
{
    /**
     * @var string
     */
    protected $table = 'acordo';

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

    public function posicoes()
    {
        return $this->hasMany(AcordoPosicao::class, 'ac26_acordo', 'ac16_sequencial');
    }

}
