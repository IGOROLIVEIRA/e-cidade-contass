<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class AutorizaUsuarioExcluirPgtoParcial extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'arrecadacao.autorizausuarioexcluirpgtoparcial';

    /**
     * @var string
     */
    protected $primaryKey = 'id_usuario';

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
        'id_usuario'
    ];
}
