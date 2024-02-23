<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class DBUsuarios extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'configuracoes.db_usuarios';

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
        'id_usuario',
        'nome',
        'login',
        'senha',
        'usuarioativo',
        'email',
        'usuext',
        'administrador',
        'datatoken',
    ];

    public function getNomeUpperAttribute()
    {
        return strtoupper($this->nome);
    }

    public function getLoginLowerAttribute()
    {
        return strtolower($this->login);
    }

    public function getEmailLowerAttribute()
    {
        return strtolower($this->email);
    }
}

