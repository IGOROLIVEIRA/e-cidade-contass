<?php

namespace App\Domain\Financeiro\Contabilidade\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Financeiro\Contabilidade\Mappers\PlanoContas\PlanoContas;
use App\Domain\Financeiro\Contabilidade\Services\ManutencaoPlanoOrcamentarioReceitaService;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\MapeamentoPlanoReceitaService;
use App\Domain\Financeiro\Contabilidade\Services\VincularPlanoOrcamentarioReceitaService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanoOrcamentarioReceitaController extends Controller
{
    /**
     * @param $estrutural
     * @param $exercicio
     * @return DBJsonResponse
     */
    public function getReceitasSemUso($estrutural, $exercicio)
    {
        $service = new ManutencaoPlanoOrcamentarioReceitaService();
        $receitasExcluir = $service->buscarReceitasParaExcluisao($estrutural, $exercicio);
        return new DBJsonResponse(array_values($receitasExcluir->toArray()), 'Receitas a serem exclu�das.');
    }

    public function exclusaoGeral(Request $request)
    {
        $contas = \JSON::create()->parse(str_replace('\"', '"', $request->contas));
        $service = new ManutencaoPlanoOrcamentarioReceitaService();
        $service->excluirContas($contas);

        $retorno = [];
        $msgLog = $service->getLog();

        if (!empty($msgLog)) {
            $retorno = ['logs' => $msgLog];
        }
        return new DBJsonResponse($retorno, 'Contas exclu�das com sucesso.');
    }

    public function getContasPadrao(Request $request)
    {
        $service = new VincularPlanoOrcamentarioReceitaService();
        $contas = $service->getContasPadrao($request->all());

        return new DBJsonResponse($contas, 'Contas encontradas.');
    }

    public function getContasEcidade(Request $request)
    {
        $service = new VincularPlanoOrcamentarioReceitaService();
        $contas = $service->getContasEcidade($request->all());
        return new DBJsonResponse(array_values($contas), 'Contas encontradas.');
    }

    public function vincular(Request $request)
    {
        $service = new VincularPlanoOrcamentarioReceitaService();
        $planoOrcamentario = $service->getPlanoOrcamentario($request->get('planoorcamentario_id'));
        $service->vincular($planoOrcamentario, $request->get('contas_ecidade'));
        return new DBJsonResponse([], 'Contas vinculadas com sucesso.');
    }

    public function desvincular(Request $request)
    {
        $service = new VincularPlanoOrcamentarioReceitaService();
        $codigo = $request->get('conplanoorcamento_codigo');
        $service->desvincular($codigo, $request->get('tipoPlano'), PlanoContas::ORIGEM_RECEITA);
        return new DBJsonResponse([], 'Contas vinculadas com sucesso.');
    }

    public function vinculoGeral(Request $request)
    {
        $service = new VincularPlanoOrcamentarioReceitaService();
        $service->vinculoGeral($request->all());
        return new DBJsonResponse([], 'Contas vinculadas com sucesso.');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function mapeamento(Request $request)
    {
        $service = new MapeamentoPlanoReceitaService();
        $service->filtros($request->all());
        return new DBJsonResponse($service->emitir(), 'Mapeamento das contas v�culadas.');
    }
}
