<?php

namespace App\Domain\Financeiro\Contabilidade\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Financeiro\Contabilidade\Requests\ImportarPcaspRequest;
use App\Domain\Financeiro\Contabilidade\Services\ImportarPcaspService;
use App\Domain\Financeiro\Contabilidade\Services\ImportarPlanoDespesaService;
use App\Domain\Financeiro\Contabilidade\Services\ImportarPlanoReceitaService;
use App\Http\Controllers\Controller;

class ImportarPlanoContasController extends Controller
{
    public function pcasp(ImportarPcaspRequest $request)
    {
        $service = new ImportarPcaspService();
        $service->setFiltrosFromRequest($request->all());
        $service->processar();
        return new DBJsonResponse([], "Planilha do PCASP importada com sucesso.");
    }

    public function despesa(ImportarPcaspRequest $request)
    {
        $service = new ImportarPlanoDespesaService();
        $service->setFiltrosFromRequest($request->all());
        $service->processar();
        return new DBJsonResponse([], "Planilha do Or�ament�rio da Despesa importado com sucesso.");
    }

    public function receita(ImportarPcaspRequest $request)
    {
        $service = new ImportarPlanoReceitaService();
        $service->setFiltrosFromRequest($request->all());
        $service->processar();

        return new DBJsonResponse([], "Planilha do Or�ament�rio da Receita importado com sucesso.");
    }
}
