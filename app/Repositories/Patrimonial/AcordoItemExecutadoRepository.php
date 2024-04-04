<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoItemExecutado;
use App\Repositories\Contracts\Patrimonial\AcordoItemExecutadoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AcordoItemExecutadoRepository implements AcordoItemExecutadoRepositoryInterface
{
    private AcordoItemExecutado $model;

    public function __construct()
    {
        $this->model = new AcordoItemExecutado();
    }

    public function eItemExecutado(int $acordoItem): bool
    {
       $result = $this->model
            ->where('ac29_acordoitem', $acordoItem)
            ->get(['ac29_acordoitem']);

        if ($result->count() > 0) {
            return true;
        }

        return false;
    }


    /**
     *
     * @param integer $acordoItem
     * @return Collection|null
     */
    public function buscaItensExecutado(int $acordoItem): ?Collection
    {
        $result = $this->model
            ->where('ac29_acordoitem', $acordoItem)
            ->get(['ac29_sequencial','ac29_acordoitem','ac29_valor']);

        return $result;
    }

}

