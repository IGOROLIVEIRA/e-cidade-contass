<?php

namespace App\Domain\Educacao\Escola\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Regencia
 * @package App\Domain\Educacao\Escola\Models
 * @property integer $ed59_i_codigo
 * @property integer $ed59_i_turma
 * @property integer $ed59_i_disciplina
 * @property integer $ed59_i_qtdperiodo
 * @property string $ed59_c_condicao
 * @property string $ed59_c_freqglob
 * @property string $ed59_c_ultatualiz
 * @property date $ed59_d_dataatualiz
 * @property string $ed59_c_encerrada
 * @property integer $ed59_i_ordenacao
 * @property integer $ed59_i_serie
 * @property boolean $ed59_lancarhistorico
 * @property boolean $ed59_caracterreprobatorio
 * @property boolean $ed59_basecomum
 * @property integer $ed59_procedimento
 * @property integer $ed59_areaconhecimento
 */
class Regencia extends Model
{
    protected $table = 'escola.regencia';
    protected $primaryKey = 'ed59_i_codigo';
    public $timestamps = false;
    public $incrementing = false;

    public function disciplinaEnsino()
    {
        return $this->belongsTo(DisciplinaEnsino::class, 'ed59_i_disciplina', 'ed12_i_codigo')
            ->with('disciplina');
    }
}
