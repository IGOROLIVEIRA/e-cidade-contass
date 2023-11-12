<?php

namespace App\Domain\Financeiro\Orcamento\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Financeiro\Orcamento\Models\ClassificacaoFonteRecurso;
use App\Domain\Financeiro\Orcamento\Services\ClassificacaoFonteRecursoService;

class ClassificacaoFonteRecursoController
{
    public function index()
    {
        return new DBJsonResponse(
            ClassificacaoFonteRecurso::all()->sortBy('id'),
            'Classifica��o de fonte de recurso.'
        );
    }

    /**
     * @return DBJsonResponse
     */
    public function comSiconfi()
    {
        $service = new ClassificacaoFonteRecursoService();

        return new DBJsonResponse(
            array_values($service->getComRecursosSiconfi()->toArray()),
            'Classifica��es com recursos'
        );
    }
}
