<?php

namespace App\Domain\Patrimonial\PNCP\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Patrimonial\Licitacoes\Models\Licitacao;
use App\Domain\Patrimonial\PNCP\Enum\AmparoLegalEnum;
use App\Domain\Patrimonial\PNCP\Enum\InstrumentoConvocatorioEnum;
use App\Domain\Patrimonial\PNCP\Enum\ModoDisputaEnum;
use App\Domain\Patrimonial\PNCP\Models\ComprasPncp;
use App\Domain\Patrimonial\PNCP\Requests\InclusaoCEARequest;
use App\Domain\Patrimonial\PNCP\Services\CompraEditalAvisoService;
use App\Domain\Patrimonial\PNCP\Services\ItensLicitacaoService;
use Illuminate\Http\Request;

class CompraEditalAvisoController
{
    public function buscarAmparosLegais(Request $request)
    {
        $modalidade = $request->get('modalidadeCompra');
        $instrumentoConvocatorio = $request->get('instrumentoConvocatorio');
        $amparosLegais = AmparoLegalEnum::getAmparosLegais($modalidade, $instrumentoConvocatorio);
        return new DBJsonResponse($amparosLegais);
    }

    public function buscarInstrumentoConvocatorio(Request $request)
    {
        $intrumentoConvocatorio = InstrumentoConvocatorioEnum::getInstrumentoConvocatorio(
            $request->get('modalidadeCompra')
        );
        return new DBJsonResponse($intrumentoConvocatorio);
    }

    public function buscarModoDisputa(Request $request)
    {
        $modosDisputas = ModoDisputaEnum::getModoDisputa($request->get('instrumentoConvocatorio'));
        return new DBJsonResponse($modosDisputas);
    }

    /**
     * @throws \Exception
     */
    public function buscarLicitacao(Request $request, ItensLicitacaoService $service)
    {
        $instituicao = \InstituicaoRepository::getInstituicaoByCodigo($request->DB_instit);
        $cnpj = $instituicao->getCNPJ();
        $licitacao = $service->dadosLicitacao($request->get('licitacao'), $request->get('resultadoItem'), $cnpj);
        return new DBJsonResponse($licitacao);
    }

    public function incluirCompraEditalAviso(InclusaoCEARequest $request, CompraEditalAvisoService $service)
    {
        $response = $service->incluirCompra($request);
        return new DBJsonResponse($response);
    }

    public function buscarEditais(Request $request, CompraEditalAvisoService $service)
    {
        $response = $service->buscarEditais($request->get('licitacao'));
        return new DBJsonResponse($response);
    }

    public function incluirRespostaItem(Request $request, CompraEditalAvisoService $service)
    {
        $response = $service->incluirResultadoItem($request->licitacao, $request->cnpj, $request->itensCompra);
        return new DBJsonResponse([], $response);
    }

    public function buscarCompras(Request $request)
    {
        $response = ComprasPncp::where('pn03_instituicao', $request->get('DB_instit'))
            ->join('unidadespncp', 'pn02_unidade', 'pn03_unidade')
            ->join('liclicita', 'l20_codigo', 'pn03_liclicita')
            ->join('cflicita', 'l20_codtipocom', 'l03_codigo')
            ->get();
        return new DBJsonResponse($response);
    }

    public function buscarCompra(Request $request, CompraEditalAvisoService $service)
    {
        $response = $service->buscarCompra($request);
        return new DBJsonResponse($response);
    }


    public function excluirCompra(Request $request, CompraEditalAvisoService $service)
    {
        $response = $service->excluirCompra($request->get('cnpj'), $request->get('codigoCompra'));
        return new DBJsonResponse([], $response);
    }
}
