<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoItem;
use App\Repositories\Contracts\Patrimonial\AcordoItemRepositoryInterface;

class AcordoItemRpository implements AcordoItemRepositoryInterface
{
    private AcordoItem $model;

    public function __construct()
    {
        $this->model = new AcordoItem();
    }

    public function update(int $codigo, array $data)
    {
        $acordoItem = $this->model->find($codigo);
        $acordoItem->update($data);
    }
}
