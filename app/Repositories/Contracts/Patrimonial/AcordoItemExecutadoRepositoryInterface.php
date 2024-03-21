<?php

namespace App\Repositories\Contracts\Patrimonial;

use Illuminate\Database\Eloquent\Collection;

interface AcordoItemExecutadoRepositoryInterface
{
    /**
     * @param integer $acordoItem
     * @return boolean
     */
    public function eItemExecutado(int $acordoItem): bool;

    /**
     *
     * @param integer $acordoItem
     * @return Collection|null
     */
    public function buscaItensExecutado(int $acordoItem): ?Collection;
}


