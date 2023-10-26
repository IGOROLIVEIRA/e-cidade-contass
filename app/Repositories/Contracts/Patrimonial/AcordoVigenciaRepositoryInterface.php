<?php

namespace App\Repositories\Contracts\Patrimonial;


interface AcordoVigenciaRepositoryInterface
{
    public function update(int $codigoPosicao, array $dados): bool;
}
