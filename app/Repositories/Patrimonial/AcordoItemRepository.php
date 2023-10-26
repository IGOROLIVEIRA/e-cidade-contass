<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoItem;
use App\Repositories\Contracts\Patrimonial\AcordoItemRepositoryInterface;

class AcordoItemRepository implements AcordoItemRepositoryInterface
{
    /**
     *
     * @var AcordoItem
     */
    private AcordoItem $model;

    public function __construct()
    {
        $this->model = new AcordoItem();
    }

    /**
     *
     * @param integer $codigo
     * @param array $dados
     * @return boolean
     */
    public function update(int $codigo, array $dados): bool
    {
        $acordoItem = $this->model->find($codigo);
        return $acordoItem->update($dados);
    }
}
