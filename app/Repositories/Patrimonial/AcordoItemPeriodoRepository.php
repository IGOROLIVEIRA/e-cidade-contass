<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoItemPeriodo;
use App\Repositories\Contracts\Patrimonial\AcordoItemPeriodoRepositoryInterface;
use Illuminate\Database\Capsule\Manager as DB;

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
       return DB::table('acordoitemperiodo')->where('ac41_acordoitem',$codigoItem)->update($dados);
    }

    /**
     *
     * @param array $dados
     * @return AcordoItemPeriodo|null
     */
    public function insert(array $dados): ?AcordoItemPeriodo
    {
        $dados['ac41_sequencial'] = $this->model->getNextval();
       return $this->model->create($dados);
    }
}
