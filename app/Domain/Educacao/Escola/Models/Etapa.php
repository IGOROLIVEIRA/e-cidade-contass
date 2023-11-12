<?php

namespace App\Domain\Educacao\Escola\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Etapa
 * @package App\Domain\Educacao\Escola\Models
 * @property integer $ed11_i_codigo
 * @property integer $ed11_i_ensino
 * @property string $ed11_c_descr
 * @property string $ed11_c_abrev
 * @property integer $ed11_i_sequencia
 * @property integer $ed11_i_codcenso
 */
class Etapa extends Model
{
    protected $table = 'escola.serie';
    protected $primaryKey = 'ed11_i_codigo';
    public $timestamps = false;
    public $incrementing = false;

    public function ensino()
    {
        return $this->belongsTo(Ensino::class, 'ed11_i_ensino', 'ed10_i_codigo');
    }
}
