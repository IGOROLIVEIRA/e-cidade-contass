<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoItemPeriodo;
use App\Repositories\Contracts\Patrimonial\AcordoItemPeriodoRepositoryInterface;

class AcordoItemPeriodoRepository implements AcordoItemPeriodoRepositoryInterface
{
    /**
     *
     * @var AcordoItemPeriodo
     */
    private AcordoItemPeriodo $model;

    public function __construct()
    {
        $this->model = new AcordoItemPeriodo();
    }

    /**
     *
     * @param integer $codigoItem
     * @param array $data
     * @return boolean
     */
    public function update(int $codigoItem, array $dados): bool
    {
        $acordoItemPeriodo = $this->model->where('ac41_acordoitem',$codigoItem)->first();
        return $acordoItemPeriodo->update($dados);
    }

      /**
     * @param array $dados
     * @return boolean
     */
    public function insert(array $dados): bool
    {
       return $this->model->create($dados);
    }
}
