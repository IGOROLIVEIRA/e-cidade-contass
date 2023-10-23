<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoPosicaoAditamento;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoAditamentoRepositoryInterface;

class AcordoPosicaoAditamentoRepository implements AcordoPosicaoAditamentoRepositoryInterface
{
    private AcordoPosicaoAditamento $model;

    public function __construct()
    {
        $this->model = new AcordoPosicaoAditamento();
    }

    public function update(int $codigo, array $data)
    {
        $acordoItem = $this->model->find($codigo);
        $acordoItem->update($data);
    }
}
