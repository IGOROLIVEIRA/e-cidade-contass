<?php

namespace App\Domain\Educacao\Escola\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TurmaEtapaRegimeMatricula
 * @package App\Domain\Educacao\Escola\Models
 * @property integer $ed220_i_codigo
 * @property integer $ed220_i_turma
 * @property integer $ed220_i_serieregimemat
 * @property string $ed220_c_historico
 * @property integer $ed220_i_procedimento
 * @property string $ed220_c_aprovauto
 */
class TurmaEtapaRegimeMatricula extends Model
{
    protected $table = 'escola.turmaserieregimemat';
    protected $primaryKey = 'ed220_i_codigo';
    public $timestamps = false;
    public $incrementing = false;

    public function procedimento()
    {
        return $this->belongsTo(Procedimento::class, 'ed220_i_procedimento', 'ed40_i_codigo')
            ->with("procedimentosAvaliacao");
    }
}
