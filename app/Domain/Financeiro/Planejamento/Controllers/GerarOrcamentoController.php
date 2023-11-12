<?php


namespace App\Domain\Financeiro\Planejamento\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Financeiro\Planejamento\Requests\Orcamento\GerarRequest;
use App\Domain\Financeiro\Planejamento\Services\GerarOrcamentoService;
use App\Http\Controllers\Controller;
use ECidade\Financeiro\Orcamento\Repository\DotacaoRepository;

class GerarOrcamentoController extends Controller
{
    public function exportar(GerarRequest $request)
    {
        $service = new GerarOrcamentoService($request->planejamento_id);
        $service->gerar();
        return new DBJsonResponse([], 'Or�amento gerado com sucesso.');
    }

    public function cancelar(GerarRequest $request)
    {
        $service = new GerarOrcamentoService($request->planejamento_id);
        $service->excluir();

        return new DBJsonResponse([], 'Or�amento cancelado com sucesso.');
    }
}
