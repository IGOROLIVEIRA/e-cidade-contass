<?php

namespace App\Models;

class Iptubase extends LegacyModel
{
    /**
     * @var string
     */
    protected $table = 'cadastro.iptubase';

    /**
     * @var string
     */
    protected $primaryKey = 'j01_matric';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'j01_matric',
        'j01_numcgm',
        'j01_idbql',
        'j01_baixa',
        'j01_codave',
        'j01_fracao'
    ];
}
