<?php

namespace App\Repositories\Contracts\Patrimonial;


interface AcordoPosicaoAditamentoRepositoryInterface
{
    public function update(int $codigo, array $data);
}
