<?php

namespace App\Repositories\Patrimonial;


use App\Models\AcordoVigencia;
use App\Repositories\Contracts\Patrimonial\AcordoVigenciaRepositoryInterface;
use Illuminate\Database\Capsule\Manager as DB;

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
        return DB::table('acordovigencia')->where('ac18_acordoposicao',$codigoPosicao)->update($dados);
    }

    public function insert(array $dados): ?AcordoVigencia
    {
        $dados['ac41_sequencial'] = $this->model->getNextval();
        return $this->model->create($dados);
    }
}
