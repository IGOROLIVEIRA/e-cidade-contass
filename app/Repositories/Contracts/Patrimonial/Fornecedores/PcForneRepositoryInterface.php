<?php

namespace App\Repositories\Contracts\Patrimonial\Fornecedores;

use Illuminate\Database\Eloquent\Collection;

interface PcForneRepositoryInterface
{
   public function getForneByStatusBlockWithCgm(string $ativo): Collection;
}

