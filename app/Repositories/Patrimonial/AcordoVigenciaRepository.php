<?php

namespace App\Repositories\Patrimonial;


use App\Models\AcordoVigencia;
use App\Repositories\Contracts\Patrimonial\AcordoVigenciaRepositoryInterface;

;

class AcordoVigenciaRepository implements AcordoVigenciaRepositoryInterface
{
    /**
     *
     * @var AcordoVigencia
     */
    private AcordoVigencia $model;

    public function __construct()
    {
        $this->model = new AcordoVigencia();
    }

    /**
     *
     * @param integer $codigo
     * @param array $dados
     * @return boolean
     */
    public function update(int $codigoPosicao, array $dados): bool
    {
        $acordoVigencia = $this->model->where('ac18_acordoposicao',$codigoPosicao)->first();
        return $acordoVigencia->update($dados);
    }
}
