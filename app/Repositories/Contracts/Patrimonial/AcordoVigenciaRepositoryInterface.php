<?php

namespace App\Repositories\Contracts\Patrimonial;

interface AcordoVigenciaRepositoryInterface
{
    /**
     *
     * @param integer $codigoPosicao
     * @param array $dados
     * @return boolean
     */
    public function update(int $codigoPosicao, array $dados): bool;
}
