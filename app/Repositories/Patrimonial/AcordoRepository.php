<?php

namespace App\Repositories\Patrimonial;

use App\Models\Acordo;
use App\Repositories\Contracts\Patrimonial\AcordoRepositoryInterface;

class AcordoRepository implements AcordoRepositoryInterface
{
    /**
     *
     * @var Acordo
     */
    private Acordo $model;

    public function __construct()
    {
        $this->model = new Acordo();
    }

    /**
     *
     * @param integer $codigoAcordo
     * @param array $fields
     * @return Acordo
     */
    public function getAcordo(int $codigoAcordo, $fields = ['*']): Acordo
    {
       return $this->model->where('ac16_sequencial', $codigoAcordo)->first($fields);
    }
}
