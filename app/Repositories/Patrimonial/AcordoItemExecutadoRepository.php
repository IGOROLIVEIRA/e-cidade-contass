<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoItemExecutado;

class AcordoItemExecutadoRepository
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
}

