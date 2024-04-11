<?php

namespace App\Repositories\Contracts\Patrimonial;


interface AcordoPosicaoAditamentoRepositoryInterface
{
    /**
     * Undocumented function
     *
     * @param integer $codigo
     * @param array $dados
     * @return boolean
     */
    public function update(int $codigo, array $dados): bool;
}
