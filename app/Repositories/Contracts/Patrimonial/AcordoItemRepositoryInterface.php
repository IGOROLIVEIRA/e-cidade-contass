<?php

namespace App\Repositories\Contracts\Patrimonial;


interface AcordoItemRepositoryInterface
{
    public function update(int $codigo, array $data);
}
