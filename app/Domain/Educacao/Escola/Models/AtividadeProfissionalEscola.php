<?php

namespace App\Domain\Educacao\Escola\Models;

use Illuminate\Database\Eloquent\Model;

class AtividadeProfissionalEscola extends Model
{
    protected $table = 'escola.rechumanoativ';
    protected $primaryKey = 'ed22_i_codigo';
    public $timestamps = false;
    public $incrementing = false;
}
