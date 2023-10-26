<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoPosicaoAditamento;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoAditamentoRepositoryInterface;

class AcordoPosicaoAditamentoRepository implements AcordoPosicaoAditamentoRepositoryInterface
{
    /**
     * @var AcordoPosicaoAditamento
     */
    private AcordoPosicaoAditamento $model;

    public function __construct()
    {
        $this->model = new AcordoPosicaoAditamento();
    }

    /**
     *
     * @param integer $codigo
     * @param array $dados
     * @return boolean
     */
    public function update(int $codigo, array $dados): bool
    {
        $acordoPosicaoAditamento = $this->model->find($codigo);
        return $acordoPosicaoAditamento->update($dados);
    }
}
