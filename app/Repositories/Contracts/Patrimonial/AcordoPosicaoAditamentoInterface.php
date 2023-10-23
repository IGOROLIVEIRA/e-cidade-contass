<?php

namespace App\Repositories\Contracts\Patrimonial;


interface AcordoPosicaoAditamentoInterface
{
    public function update(int $codigo, array $data);
}
